<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly FirstOrderDiscountService $firstOrderDiscountService,
    ) {}

    /**
     * Place an order inside a database transaction.
     *
     * Converts the active cart into a persisted Order with all snapshots,
     * an initial Payment record, and an opening OrderStatusHistory entry.
     *
     * @throws \RuntimeException when the cart is empty.
     */
    public function placeOrder(StoreOrderRequest $request): Order
    {
        $data = $request->validated();
        $cart = $this->cartService->getCart()->load('items');
        $ipAddress = $request->ip();
        $userAgent = mb_substr((string) $request->userAgent(), 0, 500);

        if ($cart->items->isEmpty()) {
            throw new \RuntimeException('Your cart is empty. Please add items before checking out.');
        }

        return DB::transaction(function () use ($data, $cart, $ipAddress, $userAgent): Order {
            $totals = $this->cartService->getCartTotals();
            $shippingAmount = (float) setting('site.shipping_cost', 0);
            $grandTotal = round($totals['total'] + $shippingAmount, 2);
            $currency = strtoupper((string) config('services.stripe.currency', 'usd'));
            $firstOrderDiscount = $totals['first_order_discount'];

            $resolvedUser = $this->resolveCustomerUser($data['email']);
            $resolvedUserId = $resolvedUser?->id;

            $paymentMethod = PaymentMethod::from($data['payment_method']);
            $shippingSame = (bool) ($data['shipping_same_as_billing'] ?? true);
            $paymentStatus = $paymentMethod === PaymentMethod::CashOnDelivery
                ? PaymentStatus::Unpaid
                : PaymentStatus::Pending;

            $order = Order::create([
                'user_id' => $resolvedUserId,
                'cart_id' => $cart->id,
                // Billing
                'customer_first_name' => $data['first_name'],
                'customer_last_name' => $data['last_name'],
                'customer_email' => $data['email'],
                'customer_phone' => $data['phone'],
                'company_name' => $data['company_name'] ?? null,
                'country' => $data['country'],
                'street_address' => $data['street_address'],
                'apartment' => $data['apartment'] ?? null,
                'city' => $data['city'],
                'state' => $data['state'],
                'zip_code' => $data['zip_code'],
                // Shipping
                'shipping_same_as_billing' => $shippingSame,
                'shipping_first_name' => $shippingSame ? null : ($data['shipping_first_name'] ?? null),
                'shipping_last_name' => $shippingSame ? null : ($data['shipping_last_name'] ?? null),
                'shipping_phone' => $shippingSame ? null : ($data['shipping_phone'] ?? null),
                'shipping_country' => $shippingSame ? null : ($data['shipping_country'] ?? null),
                'shipping_street_address' => $shippingSame ? null : ($data['shipping_street_address'] ?? null),
                'shipping_apartment' => $shippingSame ? null : ($data['shipping_apartment'] ?? null),
                'shipping_city' => $shippingSame ? null : ($data['shipping_city'] ?? null),
                'shipping_state' => $shippingSame ? null : ($data['shipping_state'] ?? null),
                'shipping_zip_code' => $shippingSame ? null : ($data['shipping_zip_code'] ?? null),
                // Extras
                'order_notes' => $data['order_notes'] ?? null,
                // Payment
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentStatus,
                // Amounts
                'subtotal' => $totals['subtotal'],
                'shipping_amount' => $shippingAmount,
                'tax_amount' => $totals['tax'],
                'discount_amount' => $totals['discount'],
                'coupon_code' => $totals['coupon']['code'] ?? null,
                'first_order_discount_applied' => (bool) $firstOrderDiscount,
                'first_order_discount_rate' => (float) ($firstOrderDiscount['rate'] ?? 0),
                'total_amount' => $grandTotal,
                // Meta
                'currency' => $currency,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
            ]);

            // Snapshot each cart line item
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'product_name' => $item->product_name,
                    'variant_label' => $item->variant_label,
                    'sku' => $item->sku,
                    'image' => $item->image,
                    'unit_price' => $item->price,
                    'quantity' => $item->quantity,
                    'line_total' => round((float) $item->price * $item->quantity, 2),
                    'tax_amount' => 0,
                    'discount_amount' => 0,
                ]);
            }

            // Record the initial payment attempt
            Payment::create([
                'order_id' => $order->id,
                'method' => $paymentMethod->value,
                'gateway' => $paymentMethod === PaymentMethod::CreditCard ? 'stripe' : null,
                'transaction_id' => null,
                'payment_intent_id' => null,
                'amount' => $grandTotal,
                'currency' => $currency,
                'status' => $paymentStatus->value,
                'payload' => null,
                'paid_at' => null,
            ]);

            // Opening status history entry
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'old_status' => null,
                'new_status' => OrderStatus::Pending->value,
                'note' => 'Order placed by customer.',
                'changed_by' => Auth::id(),
            ]);

            // Increment coupon used_count (with lock to prevent race conditions)
            $couponCode = $totals['coupon']['code'] ?? null;
            if ($couponCode) {
                /** @var Coupon|null $coupon */
                $coupon = Coupon::query()
                    ->lockForUpdate()
                    ->whereRaw('LOWER(code) = ?', [mb_strtolower($couponCode)])
                    ->first();

                if (! $coupon || ! $coupon->isAvailable()) {
                    throw new \RuntimeException('The coupon "'.$couponCode.'" is no longer valid or has reached its usage limit.');
                }

                $coupon->increment('used_count');
            }

            // Clear cart immediately only for non-card flows (e.g., COD).
            // For card payments we keep cart until payment succeeds.
            if (! in_array($paymentMethod, [PaymentMethod::CreditCard, PaymentMethod::GooglePay], true)) {
                $cart->update(['status' => 'converted']);
                $cart->items()->delete();
                $this->cartService->removeCoupon();
            }

            if ($order->first_order_discount_applied) {
                $this->firstOrderDiscountService->consumeForOrder($order->load('user'));
            }

            return $order;
        });
    }

    private function resolveCustomerUser(string $checkoutEmail): ?User
    {
        if (Auth::check() && Auth::user() instanceof User) {
            return Auth::user();
        }

        return User::query()
            ->whereRaw('LOWER(email) = ?', [mb_strtolower(trim($checkoutEmail))])
            ->first();
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethod;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\OrderNotificationService;
use App\Services\StripePaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly CheckoutService $checkoutService,
        private readonly OrderNotificationService $orderNotificationService,
        private readonly StripePaymentService $stripePaymentService,
    ) {}

    public function index(): View|RedirectResponse
    {
        $cart = $this->cartService->getCart()->load('items');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty. Please add items before checking out.');
        }

        $totals = $this->cartService->getCartTotals();
        $shippingAmount = (float) setting('site.shipping_cost', 0);
        $grandTotal = round($totals['total'] + $shippingAmount, 2);

        $user = Auth::user();
        $nameParts = $user ? explode(' ', (string) $user->name, 2) : [];
        $prefill = [
            'first_name' => $nameParts[0] ?? '',
            'last_name' => $nameParts[1] ?? '',
            'email' => $user?->email ?? '',
            'phone' => $user?->phone ?? '',
            'street_address' => $user?->address ?? '',
            'city' => $user?->city ?? '',
            'country' => $user?->country ?? '',
        ];

        return view('pages.checkout', [
            'cart' => $cart,
            'cartItems' => $cart->items,
            'subtotal' => $totals['subtotal'],
            'discount' => $totals['discount'],
            'taxAmount' => $totals['tax'],
            'taxRate' => $totals['tax_rate'],
            'shippingAmount' => $shippingAmount,
            'grandTotal' => $grandTotal,
            'coupon' => $totals['coupon'],
            'prefill' => $prefill,
        ]);
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        try {
            $order = $this->checkoutService->placeOrder($request);
            $this->rememberOrderForGuest($order);

            // Redirect to payment page for Stripe-based methods (card & Google Pay)
            if (in_array($order->payment_method, [PaymentMethod::CreditCard, PaymentMethod::GooglePay], true)) {
                $this->stripePaymentService->createPaymentIntent($order);

                return redirect()->route('payment.show', ['orderNumber' => $order->order_number]);
            }
        } catch (\RuntimeException $e) {
            return back()->withErrors(['cart' => $e->getMessage()])->withInput();
        } catch (\Throwable $e) {
            Log::error('Checkout failed.', [
                'message' => $e->getMessage(),
            ]);

            return back()->withErrors(['cart' => 'Unable to place your order at the moment. Please try again.'])->withInput();
        }

        // For non-card payments (PayPal, Cash on Delivery), redirect to confirmation
        $this->orderNotificationService->sendOrderSuccessEmail($order);

        return redirect()->route('order.confirmation', ['orderNumber' => $order->order_number])
            ->with('success', 'Your order has been placed successfully!');
    }

    public function confirmation(string $orderNumber): View|RedirectResponse
    {
        $order = $this->resolveAccessibleOrder($orderNumber);

        if (! $order) {
            return redirect()->route('home');
        }

        return view('pages.order_confirmation', compact('order'));
    }

    private function resolveAccessibleOrder(string $orderNumber): ?Order
    {
        $query = Order::with('items')->where('order_number', $orderNumber);

        if (Auth::check()) {
            return $query->where('user_id', Auth::id())->first();
        }

        $allowedOrderNumbers = collect(session('checkout_order_numbers', []));

        if (! $allowedOrderNumbers->contains($orderNumber)) {
            return null;
        }

        return $query->first();
    }

    private function rememberOrderForGuest(Order $order): void
    {
        if (Auth::check()) {
            return;
        }

        $allowedOrderNumbers = collect(session('checkout_order_numbers', []))
            ->push($order->order_number)
            ->unique()
            ->values()
            ->all();

        session(['checkout_order_numbers' => $allowedOrderNumbers]);
    }
}

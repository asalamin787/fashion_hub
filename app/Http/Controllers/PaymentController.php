<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderNotificationService;
use App\Services\StripePaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly OrderNotificationService $orderNotificationService,
        private readonly StripePaymentService $stripePaymentService,
    ) {}

    public function show(Request $request, string $orderNumber): View|RedirectResponse
    {
        $order = $this->resolveAccessibleOrder($orderNumber);

        if (! $order) {
            return redirect()->route('home');
        }

        $this->rememberOrderForGuest($order);

        if ($request->filled('payment_intent')) {
            try {
                $order = $this->stripePaymentService->syncPaymentIntentForOrder(
                    $order,
                    (string) $request->string('payment_intent')
                );
            } catch (\RuntimeException $e) {
                return redirect()
                    ->route('checkout.payment.failed', ['orderNumber' => $order->order_number])
                    ->with('error', $e->getMessage());
            }
        }

        // If order is already paid, redirect to success
        if ($order->payment_status === PaymentStatus::Paid) {
            return redirect()->route('checkout.payment.success', ['orderNumber' => $orderNumber]);
        }

        // Prepare Stripe details if payment method is Stripe-based (card or Google Pay)
        $stripePublishableKey = null;
        $clientSecret = null;

        $isStripePayment = in_array($order->payment_method, [PaymentMethod::CreditCard, PaymentMethod::GooglePay], true);

        if ($isStripePayment) {
            $stripePublishableKey = config('services.stripe.publishable_key');

            try {
                // Create or retrieve payment intent
                $intent = $this->stripePaymentService->createPaymentIntent($order);
                $clientSecret = $intent['client_secret'];
            } catch (\Throwable $e) {
                Log::error('Failed to create payment intent', [
                    'order_number' => $orderNumber,
                    'message' => $e->getMessage(),
                ]);

                return redirect()
                    ->route('checkout.payment.failed', ['orderNumber' => $orderNumber])
                    ->with('error', 'Failed to initialize payment. Please try again.');
            }
        }

        return view('pages.payment', [
            'order' => $order,
            'stripePublishableKey' => $stripePublishableKey,
            'clientSecret' => $clientSecret,
        ]);
    }

    public function processStripePayment(Request $request, string $orderNumber): JsonResponse
    {
        $validated = $request->validate([
            'payment_intent_id' => ['required', 'string', 'max:191'],
        ]);

        $order = $this->resolveAccessibleOrder($orderNumber);

        if (! $order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        $this->rememberOrderForGuest($order);

        $isStripePayment = in_array($order->payment_method, [PaymentMethod::CreditCard, PaymentMethod::GooglePay], true);

        if (! $isStripePayment) {
            return response()->json(['message' => 'This order is not a Stripe payment.'], 422);
        }

        if ($order->payment_status === PaymentStatus::Paid) {
            return response()->json([
                'redirect_url' => route('checkout.payment.success', ['orderNumber' => $order->order_number]),
            ]);
        }

        try {
            $updatedOrder = $this->stripePaymentService->syncPaymentIntentForOrder(
                $order,
                $validated['payment_intent_id']
            );
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'redirect_url' => $updatedOrder->payment_status === PaymentStatus::Paid
                ? route('checkout.payment.success', ['orderNumber' => $updatedOrder->order_number])
                : route('checkout.payment.failed', ['orderNumber' => $updatedOrder->order_number]),
        ]);
    }

    public function success(string $orderNumber): View|RedirectResponse
    {
        $order = $this->resolveAccessibleOrder($orderNumber);

        if (! $order) {
            return redirect()->route('home');
        }

        $this->rememberOrderForGuest($order);
        $this->cartService->removeCoupon();
        $this->orderNotificationService->sendOrderSuccessEmail($order);
        $this->orderNotificationService->sendPaymentSuccessEmail($order);

        return view('pages.payment_success', compact('order'));
    }

    public function failed(string $orderNumber): View|RedirectResponse
    {
        $order = $this->resolveAccessibleOrder($orderNumber);

        if (! $order) {
            return redirect()->route('home');
        }

        $this->rememberOrderForGuest($order);

        return view('pages.payment_failed', compact('order'));
    }

    private function resolveAccessibleOrder(string $orderNumber): ?Order
    {
        $query = Order::query()
            ->with('items')
            ->where('order_number', $orderNumber);

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

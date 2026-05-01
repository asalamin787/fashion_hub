<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Services\StripePaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(
        private readonly StripePaymentService $stripePaymentService,
    ) {}

    public function show(string $orderNumber): View|RedirectResponse
    {
        $order = Order::query()
            ->where('order_number', $orderNumber)
            ->when(Auth::check(), fn ($q) => $q->where('user_id', Auth::id()))
            ->first();

        if (! $order) {
            return redirect()->route('home');
        }

        // If order is already paid, redirect to success
        if ($order->payment_status === PaymentStatus::Paid) {
            return redirect()->route('checkout.payment.success', ['orderNumber' => $orderNumber]);
        }

        // Prepare Stripe details if payment method is credit card
        $stripePublishableKey = null;
        $clientSecret = null;

        if ($order->payment_method === PaymentMethod::CreditCard) {
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

    public function processStripePayment(): JsonResponse
    {
        $validated = request()->validate([
            'order_number' => ['required', 'string', 'max:50'],
            'payment_intent_id' => ['required', 'string', 'max:191'],
        ]);

        $order = Order::query()
            ->where('order_number', $validated['order_number'])
            ->when(Auth::check(), fn ($q) => $q->where('user_id', Auth::id()))
            ->first();

        if (! $order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        if ($order->payment_method !== PaymentMethod::CreditCard) {
            return response()->json(['message' => 'This order is not a card payment.'], 422);
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
        $order = Order::query()
            ->where('order_number', $orderNumber)
            ->when(Auth::check(), fn ($q) => $q->where('user_id', Auth::id()))
            ->first();

        if (! $order) {
            return redirect()->route('home');
        }

        return view('pages.payment_success', compact('order'));
    }

    public function failed(string $orderNumber): View|RedirectResponse
    {
        $order = Order::query()
            ->where('order_number', $orderNumber)
            ->when(Auth::check(), fn ($q) => $q->where('user_id', Auth::id()))
            ->first();

        if (! $order) {
            return redirect()->route('home');
        }

        return view('pages.payment_failed', compact('order'));
    }
}

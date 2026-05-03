<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Charge;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

class StripePaymentService
{
    private ?StripeClient $client = null;

    /**
     * @return array{payment_intent_id: string, client_secret: string}
     */
    public function createPaymentIntent(Order $order): array
    {
        if ($order->payment_status === PaymentStatus::Paid) {
            throw new \RuntimeException('This order has already been paid.');
        }

        $currency = strtolower((string) ($order->currency ?: config('services.stripe.currency', 'usd')));
        $amountInCents = (int) round((float) $order->total_amount * 100);

        if ($amountInCents < 50) {
            throw new \RuntimeException('Order amount is too low for card payment.');
        }

        $intent = null;

        if (filled($order->stripe_payment_intent_id)) {
            $intent = $this->retrievePaymentIntent((string) $order->stripe_payment_intent_id);

            if (in_array($intent->status, ['requires_payment_method', 'requires_confirmation', 'requires_action', 'processing'], true)) {
                return [
                    'payment_intent_id' => $intent->id,
                    'client_secret' => (string) $intent->client_secret,
                ];
            }
        }

        $intent = $this->stripe()->paymentIntents->create([
            'amount' => $amountInCents,
            'currency' => $currency,
            'automatic_payment_methods' => ['enabled' => true],
            'metadata' => [
                'order_id' => (string) $order->id,
                'order_number' => $order->order_number,
                'customer_email' => $order->customer_email,
            ],
        ]);

        DB::transaction(function () use ($order, $intent, $currency): void {
            /** @var Order $lockedOrder */
            $lockedOrder = Order::query()->lockForUpdate()->findOrFail($order->id);

            $selectedStripeMethod = in_array($lockedOrder->payment_method, [PaymentMethod::CreditCard, PaymentMethod::GooglePay], true)
                ? $lockedOrder->payment_method
                : PaymentMethod::CreditCard;

            $lockedOrder->update([
                'payment_method' => $selectedStripeMethod,
                'payment_status' => PaymentStatus::Pending,
                'payment_gateway' => 'stripe',
                'stripe_payment_intent_id' => $intent->id,
            ]);

            $payment = Payment::query()
                ->where('order_id', $lockedOrder->id)
                ->latest('id')
                ->first();

            if (! $payment) {
                $payment = new Payment(['order_id' => $lockedOrder->id]);
            }

            $payment->fill([
                'method' => $selectedStripeMethod->value,
                'gateway' => 'stripe',
                'transaction_id' => null,
                'payment_intent_id' => $intent->id,
                'amount' => (float) $lockedOrder->total_amount,
                'currency' => strtoupper($currency),
                'status' => PaymentStatus::Pending->value,
                'payload' => ['intent_status' => $intent->status],
                'paid_at' => null,
            ]);

            $payment->save();
        });

        return [
            'payment_intent_id' => $intent->id,
            'client_secret' => (string) $intent->client_secret,
        ];
    }

    public function syncPaymentIntentForOrder(Order $order, string $paymentIntentId): Order
    {
        $intent = $this->retrievePaymentIntent($paymentIntentId);

        if ($order->stripe_payment_intent_id && $order->stripe_payment_intent_id !== $intent->id) {
            throw new \RuntimeException('PaymentIntent mismatch for this order.');
        }

        if ((string) data_get($intent->metadata, 'order_id') !== '' && (int) data_get($intent->metadata, 'order_id') !== (int) $order->id) {
            throw new \RuntimeException('Order ownership mismatch for this payment.');
        }

        return $this->applyPaymentIntentState($order, $intent, ['source' => 'client_confirmation']);
    }

    /**
     * @param  array<string, mixed>  $event
     */
    /**
     * @param  array<string, mixed>  $payload
     */
    public function handleWebhook(array $payload): void
    {
        $type = (string) ($payload['type'] ?? '');

        if ($type === 'payment_intent.succeeded' || $type === 'payment_intent.payment_failed') {
            $intentPayload = data_get($payload, 'data.object');

            if (! is_array($intentPayload) || ! isset($intentPayload['id'])) {
                return;
            }

            $order = $this->findOrderByIntentPayload($intentPayload);

            if (! $order) {
                return;
            }

            $intent = $this->retrievePaymentIntent((string) $intentPayload['id']);
            $this->applyPaymentIntentState($order, $intent, $payload);

            return;
        }

        if ($type === 'charge.refunded') {
            $charge = data_get($payload, 'data.object');

            if (! is_array($charge)) {
                return;
            }

            $paymentIntentId = (string) ($charge['payment_intent'] ?? '');

            if ($paymentIntentId === '') {
                return;
            }

            $order = Order::query()->where('stripe_payment_intent_id', $paymentIntentId)->first();

            if (! $order) {
                return;
            }

            DB::transaction(function () use ($order, $charge, $payload): void {
                /** @var Order $lockedOrder */
                $lockedOrder = Order::query()->lockForUpdate()->findOrFail($order->id);

                $amount = (int) ($charge['amount'] ?? 0);
                $amountRefunded = (int) ($charge['amount_refunded'] ?? 0);
                $isFullyRefunded = $amount > 0 && $amountRefunded >= $amount;

                $status = $isFullyRefunded
                    ? PaymentStatus::Refunded
                    : PaymentStatus::PartiallyRefunded;

                $lockedOrder->update([
                    'payment_status' => $status,
                    'order_status' => $isFullyRefunded ? OrderStatus::Refunded : $lockedOrder->order_status,
                    'transaction_id' => (string) ($charge['id'] ?? $lockedOrder->transaction_id),
                ]);

                $payment = Payment::query()
                    ->where('order_id', $lockedOrder->id)
                    ->where('payment_intent_id', $lockedOrder->stripe_payment_intent_id)
                    ->latest('id')
                    ->first();

                if ($payment) {
                    $payment->fill([
                        'status' => $status->value,
                        'transaction_id' => (string) ($charge['id'] ?? $payment->transaction_id),
                        'payload' => $payload,
                    ]);
                    $payment->save();
                }
            });
        }
    }

    /**
     * @param  array<string, mixed>  $event
     */
    public function handleWebhookEvent(array $event): void
    {
        $this->handleWebhook($event);
    }

    private function findOrderByIntentPayload(array $intentPayload): ?Order
    {
        $intentId = (string) ($intentPayload['id'] ?? '');

        if ($intentId === '') {
            return null;
        }

        $order = Order::query()->where('stripe_payment_intent_id', $intentId)->first();

        if ($order) {
            return $order;
        }

        $metadataOrderId = (int) ($intentPayload['metadata']['order_id'] ?? 0);

        if ($metadataOrderId > 0) {
            return Order::query()->find($metadataOrderId);
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function applyPaymentIntentState(Order $order, PaymentIntent $intent, array $payload): Order
    {
        return DB::transaction(function () use ($order, $intent, $payload): Order {
            /** @var Order $lockedOrder */
            $lockedOrder = Order::query()->lockForUpdate()->findOrFail($order->id);

            $mappedStatus = $this->mapIntentStatusToPaymentStatus((string) $intent->status);
            $isPaid = $mappedStatus === PaymentStatus::Paid;

            // Safely extract the Charge object — latest_charge is expanded via retrieve()
            $charge = $intent->latest_charge instanceof Charge ? $intent->latest_charge : null;

            // Extract only Stripe IDs — never cast the full object to string
            $chargeId = $charge?->id ?? (is_string($intent->latest_charge) ? $intent->latest_charge : null);
            $pmId = $charge?->payment_method;

            // Detect Google Pay vs card from charge wallet data
            $paymentMethod = $this->resolvePaymentMethodFromCharge($charge)
                ?? $this->resolvePaymentMethodFromIntent($intent);

            $orderUpdate = [
                'payment_gateway' => 'stripe',
                'stripe_payment_intent_id' => $intent->id,
                'payment_status' => $mappedStatus,
                'payment_method' => $paymentMethod,
            ];

            if ($isPaid) {
                $orderUpdate['paid_at'] = now();
                $orderUpdate['transaction_id'] = $chargeId ?? $lockedOrder->transaction_id;
                $orderUpdate['payment_method_id'] = $pmId ?? $lockedOrder->payment_method_id;

                if ($lockedOrder->order_status === OrderStatus::Pending) {
                    $orderUpdate['order_status'] = OrderStatus::Confirmed;
                    $orderUpdate['confirmed_at'] = now();
                }

                if ($lockedOrder->cart_id) {
                    $lockedOrder->cart()->update(['status' => 'converted']);
                    $lockedOrder->cart?->items()->delete();
                }
            }

            if ($mappedStatus === PaymentStatus::Failed) {
                // last_payment_error->charge is a charge ID string, not an object
                $failedChargeId = data_get($intent->toArray(), 'last_payment_error.charge');
                $orderUpdate['transaction_id'] = $failedChargeId ?? $lockedOrder->transaction_id;
            }

            $lockedOrder->update($orderUpdate);

            $payment = Payment::query()
                ->where('order_id', $lockedOrder->id)
                ->where('payment_intent_id', $intent->id)
                ->latest('id')
                ->first();

            if (! $payment) {
                $payment = new Payment(['order_id' => $lockedOrder->id]);
            }

            // Store full charge payload in payments.payload — NOT in transaction_id
            $chargePayload = $charge ? $charge->toArray() : [];

            $payment->fill([
                'method' => $paymentMethod->value,
                'gateway' => 'stripe',
                'transaction_id' => $chargeId ?? $payment->transaction_id,
                'payment_intent_id' => $intent->id,
                'payment_method_id' => $pmId ?? $payment->payment_method_id,
                'amount' => round(((int) $intent->amount) / 100, 2),
                'currency' => strtoupper((string) $intent->currency),
                'status' => $mappedStatus->value,
                'payload' => $chargePayload ?: $payload,
                'paid_at' => $isPaid ? now() : null,
            ]);

            $payment->save();

            return $lockedOrder->refresh();
        });
    }

    /**
     * Resolve PaymentMethod from a Stripe Charge object (most accurate).
     */
    private function resolvePaymentMethodFromCharge(?Charge $charge): ?PaymentMethod
    {
        if (! $charge) {
            return null;
        }

        $walletType = (string) data_get($charge->toArray(), 'payment_method_details.card.wallet.type', '');

        return match ($walletType) {
            'google_pay' => PaymentMethod::GooglePay,
            '' => null,
            default => PaymentMethod::CreditCard,
        };
    }

    private function mapIntentStatusToPaymentStatus(string $intentStatus): PaymentStatus
    {
        return match ($intentStatus) {
            'succeeded' => PaymentStatus::Paid,
            'requires_payment_method', 'canceled' => PaymentStatus::Failed,
            default => PaymentStatus::Pending,
        };
    }

    public function retrievePaymentIntent(string $paymentIntentId): PaymentIntent
    {
        try {
            return $this->stripe()->paymentIntents->retrieve($paymentIntentId, [
                'expand' => ['latest_charge.payment_method_details'],
            ]);
        } catch (ApiErrorException $e) {
            Log::error('Stripe PaymentIntent retrieval failed.', [
                'payment_intent_id' => $paymentIntentId,
                'message' => $e->getMessage(),
            ]);

            throw new \RuntimeException('Unable to verify payment intent from Stripe.');
        }
    }

    private function stripe(): StripeClient
    {
        if ($this->client) {
            return $this->client;
        }

        $secret = (string) config('services.stripe.secret_key');

        if (blank($secret)) {
            throw new \RuntimeException('Stripe secret key is not configured.');
        }

        $this->client = new StripeClient($secret);

        return $this->client;
    }

    private function resolvePaymentMethodFromIntent(PaymentIntent $intent): PaymentMethod
    {
        // Fallback: read wallet type from the expanded intent array
        $walletType = (string) data_get($intent->toArray(), 'latest_charge.payment_method_details.card.wallet.type', '');

        return match ($walletType) {
            'google_pay' => PaymentMethod::GooglePay,
            default => PaymentMethod::CreditCard,
        };
    }
}

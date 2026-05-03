<?php

namespace App\Http\Controllers;

use App\Models\StripeWebhookEvent;
use App\Services\StripePaymentService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request, StripePaymentService $stripePaymentService): JsonResponse
    {
        $payload = $request->getContent();
        $signature = (string) $request->header('Stripe-Signature', '');
        $webhookSecret = (string) config('services.stripe.webhook_secret');

        if (blank($webhookSecret)) {
            Log::warning('Stripe webhook received without webhook secret configured.');

            return response()->json(['message' => 'Webhook secret not configured.'], 500);
        }

        try {
            $event = Webhook::constructEvent($payload, $signature, $webhookSecret);
        } catch (SignatureVerificationException $e) {
            Log::warning('Invalid Stripe webhook signature.', ['message' => $e->getMessage()]);

            return response()->json(['message' => 'Invalid signature.'], 400);
        } catch (\UnexpectedValueException $e) {
            Log::warning('Invalid Stripe webhook payload.', ['message' => $e->getMessage()]);

            return response()->json(['message' => 'Invalid payload.'], 400);
        }

        $eventArray = $event->toArray();
        $eventId = (string) ($eventArray['id'] ?? '');
        $eventType = (string) ($eventArray['type'] ?? 'unknown');

        $webhookEvent = null;

        if ($eventId !== '') {
            try {
                $webhookEvent = StripeWebhookEvent::query()->create([
                    'event_id' => $eventId,
                    'event_type' => $eventType,
                    'order_id' => (int) data_get($eventArray, 'data.object.metadata.order_id') ?: null,
                    'payload' => $eventArray,
                ]);
            } catch (QueryException $e) {
                if ((string) $e->getCode() !== '23000') {
                    throw $e;
                }

                Log::info('Duplicate Stripe webhook event received.', ['event_id' => $eventId]);

                return response()->json(['received' => true, 'duplicate' => true]);
            }
        }

        try {
            $stripePaymentService->handleWebhook($eventArray);

            if ($webhookEvent) {
                $webhookEvent->update([
                    'processed_at' => now(),
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Stripe webhook handling failed.', [
                'event_id' => $eventId,
                'event_type' => $eventType,
                'message' => $e->getMessage(),
            ]);

            return response()->json(['message' => 'Webhook processing failed.'], 500);
        }

        return response()->json(['received' => true]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\StripePaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

        if ($eventId !== '' && ! Cache::add('stripe:webhook:event:'.$eventId, true, now()->addDay())) {
            return response()->json(['received' => true, 'duplicate' => true]);
        }

        $stripePaymentService->handleWebhookEvent($eventArray);

        return response()->json(['received' => true]);
    }
}

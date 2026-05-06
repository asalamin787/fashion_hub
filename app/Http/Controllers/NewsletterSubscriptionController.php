<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeNewsletterRequest;
use App\Mail\NewsletterFirstOrderDiscountMail;
use App\Services\NewsletterSubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class NewsletterSubscriptionController extends Controller
{
    public function __construct(private readonly NewsletterSubscriptionService $newsletterSubscriptionService) {}

    public function store(SubscribeNewsletterRequest $request): JsonResponse
    {
        $subscription = $this->newsletterSubscriptionService->subscribe((string) $request->validated('email'));
        $isEligibleForFirstOrderDiscount = (bool) ($subscription['eligible_for_first_order_discount'] ?? false);
        $autoLoggedIn = (bool) ($subscription['auto_logged_in'] ?? false);

        if ($subscription['welcome_email_should_send'] && $isEligibleForFirstOrderDiscount) {
            Mail::to($subscription['user']->email)->queue(new NewsletterFirstOrderDiscountMail($subscription['user']));
        }

        if ($isEligibleForFirstOrderDiscount) {
            $message = $autoLoggedIn
                ? 'You are subscribed, logged in automatically, and your 15% first-order discount is ready.'
                : 'You are subscribed. Your 15% first-order discount is ready.';
        } else {
            $message = $autoLoggedIn
                ? 'You are subscribed and logged in automatically, but this email already has previous order history. The first-order discount is not available for this account.'
                : 'You are subscribed, but this email already has previous order history. The first-order discount is not available for this account.';
        }

        return response()->json([
            'message' => $message,
            'already_subscribed' => $subscription['was_already_subscribed'],
            'eligible_for_first_order_discount' => $isEligibleForFirstOrderDiscount,
            'auto_logged_in' => $autoLoggedIn,
        ]);
    }
}

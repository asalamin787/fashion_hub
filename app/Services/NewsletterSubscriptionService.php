<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NewsletterSubscriptionService
{
    public function __construct(private readonly FirstOrderDiscountService $firstOrderDiscountService) {}

    /**
     * @return array{user: User, was_already_subscribed: bool, welcome_email_should_send: bool, eligible_for_first_order_discount: bool}
     */
    public function subscribe(string $email): array
    {
        $normalizedEmail = mb_strtolower(trim($email));

        /** @var array{user: User, was_already_subscribed: bool, welcome_email_should_send: bool, eligible_for_first_order_discount: bool} $result */
        $result = DB::transaction(function () use ($normalizedEmail): array {
            $user = User::query()
                ->whereRaw('LOWER(email) = ?', [$normalizedEmail])
                ->lockForUpdate()
                ->first();

            if (! $user) {
                $name = Str::of(Str::before($normalizedEmail, '@'))
                    ->replace(['.', '_', '-'], ' ')
                    ->title()
                    ->toString();

                $user = User::query()->create([
                    'name' => $name !== '' ? $name : 'Newsletter Subscriber',
                    'email' => $normalizedEmail,
                    'password' => Hash::make(Str::random(40)),
                    'role' => 'user',
                    'is_active' => true,
                    'is_subscribed' => true,
                    'subscribed_at' => now(),
                    'first_order_discount_available' => true,
                ]);

                return [
                    'user' => $user,
                    'was_already_subscribed' => false,
                    'welcome_email_should_send' => true,
                    'eligible_for_first_order_discount' => true,
                ];
            }

            $wasAlreadySubscribed = (bool) $user->is_subscribed;
            $hasAnyOrder = $this->firstOrderDiscountService->hasAnyOrder($user);

            $user->forceFill([
                'is_subscribed' => true,
                'subscribed_at' => $user->subscribed_at ?? now(),
                'first_order_discount_available' => ! $hasAnyOrder,
            ])->save();

            return [
                'user' => $user->fresh(),
                'was_already_subscribed' => $wasAlreadySubscribed,
                'welcome_email_should_send' => ! $wasAlreadySubscribed,
                'eligible_for_first_order_discount' => ! $hasAnyOrder,
            ];
        });

        session(['newsletter_subscriber_email' => $result['user']->email]);

        return $result;
    }
}

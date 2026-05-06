<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FirstOrderDiscountService
{
    public const DISCOUNT_PERCENTAGE = 15.0;

    public function resolveEligibleUser(?string $sessionEmail = null): ?User
    {
        $email = trim((string) ($sessionEmail ?? session('newsletter_subscriber_email', '')));

        if ($email !== '') {
            return User::query()->whereRaw('LOWER(email) = ?', [mb_strtolower($email)])->first();
        }

        if (Auth::check() && Auth::user() instanceof User) {
            return Auth::user();
        }

        return null;
    }

    public function isEligible(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        if (! $user->first_order_discount_available) {
            return false;
        }

        return ! $this->hasAnyOrder($user);
    }

    public function hasAnyOrder(User $user): bool
    {
        return Order::query()
            ->where(function ($query) use ($user): void {
                $query->where('user_id', $user->id)
                    ->orWhereRaw('LOWER(customer_email) = ?', [mb_strtolower((string) $user->email)]);
            })
            ->exists();
    }

    /**
     * @return array{is_eligible: bool, rate: float, amount: float}
     */
    public function calculateDiscount(float $subtotal, ?User $user): array
    {
        if ($subtotal <= 0 || ! $this->isEligible($user)) {
            return [
                'is_eligible' => false,
                'rate' => self::DISCOUNT_PERCENTAGE,
                'amount' => 0.0,
            ];
        }

        $amount = round($subtotal * (self::DISCOUNT_PERCENTAGE / 100), 2);

        return [
            'is_eligible' => true,
            'rate' => self::DISCOUNT_PERCENTAGE,
            'amount' => min($amount, $subtotal),
        ];
    }

    public function consumeForOrder(Order $order): void
    {
        if (! $order->first_order_discount_applied) {
            return;
        }

        $user = $order->user;

        if (! $user && filled($order->customer_email)) {
            $user = User::query()->whereRaw('LOWER(email) = ?', [mb_strtolower((string) $order->customer_email)])->first();
        }

        if (! $user) {
            return;
        }

        if ($user->first_order_discount_available) {
            $user->forceFill(['first_order_discount_available' => false])->save();
        }
    }
}

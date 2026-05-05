<?php

namespace App\Services;

use App\Mail\OrderCanceledMail;
use App\Mail\OrderSuccessMail;
use App\Mail\PaymentFailedMail;
use App\Mail\PaymentSuccessMail;
use App\Models\Order;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderNotificationService
{
    public function sendOrderSuccessEmail(Order $order): void
    {
        $shouldSend = DB::transaction(function () use ($order): bool {
            /** @var Order $lockedOrder */
            $lockedOrder = Order::query()->lockForUpdate()->findOrFail($order->id);
            $meta = $lockedOrder->meta ?? [];

            if (filled(Arr::get($meta, 'order_success_emailed_at'))) {
                return false;
            }

            Arr::set($meta, 'order_success_emailed_at', Carbon::now()->toIso8601String());
            $lockedOrder->forceFill(['meta' => $meta])->save();

            return true;
        });

        if (! $shouldSend) {
            return;
        }

        $freshOrder = $order->fresh(['items.product', 'user']);

        if (! $freshOrder || blank($freshOrder->customer_email)) {
            return;
        }

        Mail::to($freshOrder->customer_email)->send(
            new OrderSuccessMail($freshOrder)
        );
    }

    public function sendPaymentSuccessEmail(Order $order): void
    {
        $shouldSend = DB::transaction(function () use ($order): bool {
            /** @var Order $lockedOrder */
            $lockedOrder = Order::query()->lockForUpdate()->findOrFail($order->id);
            $meta = $lockedOrder->meta ?? [];

            if (filled(Arr::get($meta, 'payment_success_emailed_at'))) {
                return false;
            }

            Arr::set($meta, 'payment_success_emailed_at', Carbon::now()->toIso8601String());
            $lockedOrder->forceFill(['meta' => $meta])->save();

            return true;
        });

        if (! $shouldSend) {
            return;
        }

        $freshOrder = $order->fresh(['items.product', 'user']);

        if (! $freshOrder || blank($freshOrder->customer_email)) {
            return;
        }

        Mail::to($freshOrder->customer_email)->send(
            new PaymentSuccessMail($freshOrder)
        );
    }

    public function sendPaymentFailedEmail(Order $order, ?string $reason = null): void
    {
        $shouldSend = DB::transaction(function () use ($order): bool {
            /** @var Order $lockedOrder */
            $lockedOrder = Order::query()->lockForUpdate()->findOrFail($order->id);
            $meta = $lockedOrder->meta ?? [];

            // Track each failed attempt
            $failedAttempts = Arr::get($meta, 'payment_failed_attempts', []);
            $failedAttempts[] = Carbon::now()->toIso8601String();
            Arr::set($meta, 'payment_failed_attempts', $failedAttempts);

            $lockedOrder->forceFill(['meta' => $meta])->save();

            return true;
        });

        if (! $shouldSend) {
            return;
        }

        $freshOrder = $order->fresh(['items.product', 'user']);

        if (! $freshOrder || blank($freshOrder->customer_email)) {
            return;
        }

        Mail::to($freshOrder->customer_email)->send(
            new PaymentFailedMail($freshOrder, $reason)
        );
    }

    public function sendOrderCanceledEmail(Order $order): void
    {
        $shouldSend = DB::transaction(function () use ($order): bool {
            /** @var Order $lockedOrder */
            $lockedOrder = Order::query()->lockForUpdate()->findOrFail($order->id);
            $meta = $lockedOrder->meta ?? [];

            if (filled(Arr::get($meta, 'order_canceled_emailed_at'))) {
                return false;
            }

            Arr::set($meta, 'order_canceled_emailed_at', Carbon::now()->toIso8601String());
            $lockedOrder->forceFill(['meta' => $meta])->save();

            return true;
        });

        if (! $shouldSend) {
            return;
        }

        $freshOrder = $order->fresh(['items.product', 'user']);

        if (! $freshOrder || blank($freshOrder->customer_email)) {
            return;
        }

        Mail::to($freshOrder->customer_email)->send(
            new OrderCanceledMail($freshOrder)
        );
    }
}

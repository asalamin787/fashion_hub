<?php

namespace App\Services;

use App\Mail\AdminNewOrderMail;
use App\Mail\OrderCanceledMail;
use App\Mail\OrderSuccessMail;
use App\Mail\PaymentFailedMail;
use App\Mail\PaymentSuccessMail;
use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderNotificationService
{
    public function sendOrderSuccessEmail(Order $order): void
    {
        $freshOrder = $order->fresh(['items.product', 'user']);

        if (! $freshOrder || blank($freshOrder->customer_email)) {
            return;
        }

        if ($this->shouldSendEmail($freshOrder, 'order_success_customer_emailed_at')) {
            $this->queueEmail(
                $freshOrder->customer_email,
                new OrderSuccessMail($freshOrder),
                0
            );

            $this->markEmailSent($freshOrder, 'order_success_customer_emailed_at');
        }

        $adminEmail = filled(setting('mail.order_receive_mail'))
            ? setting('mail.order_receive_mail')
            : setting('mail.contact_receive_mail', config('mail.from.address'));

        if (filled($adminEmail) && $this->shouldSendEmail($freshOrder, 'order_success_admin_emailed_at')) {
            $this->queueEmail(
                (string) $adminEmail,
                new AdminNewOrderMail($freshOrder),
                2
            );

            $this->markEmailSent($freshOrder, 'order_success_admin_emailed_at');
        }
    }

    public function sendPaymentSuccessEmail(Order $order): void
    {
        $freshOrder = $order->fresh(['items.product', 'user']);

        if (! $freshOrder || blank($freshOrder->customer_email)) {
            return;
        }

        if (! $this->shouldSendEmail($freshOrder, 'payment_success_customer_emailed_at')) {
            return;
        }

        $this->queueEmail(
            $freshOrder->customer_email,
            new PaymentSuccessMail($freshOrder),
            4
        );

        $this->markEmailSent($freshOrder, 'payment_success_customer_emailed_at');
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

        $this->queueEmail(
            $freshOrder->customer_email,
            new PaymentFailedMail($freshOrder, $reason),
            1
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

        $this->queueEmail(
            $freshOrder->customer_email,
            new OrderCanceledMail($freshOrder),
            1
        );
    }

    private function queueEmail(string $recipient, Mailable $mailable, int $delaySeconds = 0): void
    {
        if ($delaySeconds > 0) {
            Mail::to($recipient)->later(now()->addSeconds($delaySeconds), $mailable);

            return;
        }

        Mail::to($recipient)->queue($mailable);
    }

    private function shouldSendEmail(Order $order, string $metaKey): bool
    {
        return DB::transaction(function () use ($order, $metaKey): bool {
            /** @var Order $lockedOrder */
            $lockedOrder = Order::query()->lockForUpdate()->findOrFail($order->id);
            $meta = $lockedOrder->meta ?? [];

            return blank(Arr::get($meta, $metaKey));
        });
    }

    private function markEmailSent(Order $order, string $metaKey): void
    {
        DB::transaction(function () use ($order, $metaKey): void {
            /** @var Order $lockedOrder */
            $lockedOrder = Order::query()->lockForUpdate()->findOrFail($order->id);
            $meta = $lockedOrder->meta ?? [];

            if (filled(Arr::get($meta, $metaKey))) {
                return;
            }

            Arr::set($meta, $metaKey, Carbon::now()->toIso8601String());
            $lockedOrder->forceFill(['meta' => $meta])->save();
        });
    }
}

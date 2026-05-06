<?php

namespace App\Filament\Widgets\Concerns;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

trait AppliesDashboardFilters
{
    protected function applyOrderFilters(
        Builder $query,
        string $dateColumn = 'created_at',
        string $orderStatusColumn = 'order_status',
        string $paymentStatusColumn = 'payment_status',
        string $paymentMethodColumn = 'payment_method'
    ): Builder {
        [$startDate, $endDate] = $this->resolveDateRange();

        return $query
            ->when(
                $startDate,
                fn (Builder $builder): Builder => $builder->whereDate($dateColumn, '>=', $startDate->toDateString())
            )
            ->when(
                $endDate,
                fn (Builder $builder): Builder => $builder->whereDate($dateColumn, '<=', $endDate->toDateString())
            )
            ->when(
                $this->getOrderStatusFilter(),
                fn (Builder $builder, string $status): Builder => $builder->where($orderStatusColumn, $status)
            )
            ->when(
                $this->getPaymentStatusFilter(),
                fn (Builder $builder, string $status): Builder => $builder->where($paymentStatusColumn, $status)
            )
            ->when(
                $this->getPaymentMethodFilter(),
                fn (Builder $builder, string $method): Builder => $builder->where($paymentMethodColumn, $method)
            );
    }

    /**
     * @return array{0: CarbonInterface, 1: CarbonInterface}
     */
    protected function resolveDateRange(): array
    {
        $today = now()->endOfDay();
        $period = (string) ($this->getFilterValue('period') ?: '30d');

        if ($period === 'custom') {
            $startDate = $this->parseDateFilter('startDate') ?? now()->subDays(29)->startOfDay();
            $endDate = $this->parseDateFilter('endDate') ?? now()->endOfDay();

            if ($startDate->gt($endDate)) {
                [$startDate, $endDate] = [$endDate->copy()->startOfDay(), $startDate->copy()->endOfDay()];
            }

            return [$startDate->copy()->startOfDay(), $endDate->copy()->endOfDay()];
        }

        return match ($period) {
            'today' => [
                now()->startOfDay(),
                now()->endOfDay(),
            ],
            '7d' => [
                now()->subDays(6)->startOfDay(),
                $today,
            ],
            '90d' => [
                now()->subDays(89)->startOfDay(),
                $today,
            ],
            'ytd' => [
                now()->startOfYear(),
                $today,
            ],
            default => [
                now()->subDays(29)->startOfDay(),
                $today,
            ],
        };
    }

    /**
     * @return array{0: CarbonInterface, 1: CarbonInterface}
     */
    protected function resolvePreviousDateRange(): array
    {
        [$startDate, $endDate] = $this->resolveDateRange();
        $daysInRange = $startDate->diffInDays($endDate) + 1;

        $previousEndDate = $startDate->copy()->subDay()->endOfDay();
        $previousStartDate = $previousEndDate->copy()->subDays($daysInRange - 1)->startOfDay();

        return [$previousStartDate, $previousEndDate];
    }

    protected function getDateRangeLabel(): string
    {
        $period = (string) ($this->getFilterValue('period') ?: '30d');

        return match ($period) {
            'today' => 'Today',
            '7d' => 'Last 7 days',
            '30d' => 'Last 30 days',
            '90d' => 'Last 90 days',
            'ytd' => 'Year to date',
            'custom' => 'Custom range',
            default => 'Selected period',
        };
    }

    protected function getOrderStatusFilter(): ?string
    {
        $value = $this->getFilterValue('orderStatus');

        if (! is_string($value)) {
            return null;
        }

        $allowedValues = collect(OrderStatus::cases())->pluck('value')->all();

        return in_array($value, $allowedValues, true) ? $value : null;
    }

    protected function getPaymentStatusFilter(): ?string
    {
        $value = $this->getFilterValue('paymentStatus');

        if (! is_string($value)) {
            return null;
        }

        $allowedValues = collect(PaymentStatus::cases())->pluck('value')->all();

        return in_array($value, $allowedValues, true) ? $value : null;
    }

    protected function getPaymentMethodFilter(): ?string
    {
        $value = $this->getFilterValue('paymentMethod');

        if (! is_string($value)) {
            return null;
        }

        $allowedValues = collect(PaymentMethod::cases())->pluck('value')->all();

        return in_array($value, $allowedValues, true) ? $value : null;
    }

    protected function getFilterValue(string $key): mixed
    {
        return data_get($this->pageFilters ?? [], $key);
    }

    protected function parseDateFilter(string $key): ?Carbon
    {
        $value = $this->getFilterValue($key);

        if (! is_string($value) || blank($value)) {
            return null;
        }

        try {
            return Carbon::parse($value);
        } catch (\Throwable) {
            return null;
        }
    }
}

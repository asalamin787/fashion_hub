<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Attributes\Reactive;

class PaymentStatusSummary extends BaseWidget
{
    use Concerns\AppliesDashboardFilters;

    #[Reactive]
    public ?array $pageFilters = null;

    protected ?string $heading = 'Payment Status Summary';

    protected int|string|array $columnSpan = 'full';

    protected ?string $pollingInterval = '20s';

    protected function getStats(): array
    {
        $query = $this->applyOrderFilters(Order::query());
        $total = $query->count();

        $paid = $query->clone()->where('payment_status', 'Paid')->count();
        $paidPercent = $total > 0 ? round(($paid / $total) * 100, 1) : 0;

        $pending = $query->clone()->where('payment_status', 'Pending')->count();
        $pendingPercent = $total > 0 ? round(($pending / $total) * 100, 1) : 0;

        $failed = $query->clone()->where('payment_status', 'Failed')->count();
        $failedPercent = $total > 0 ? round(($failed / $total) * 100, 1) : 0;

        return [
            Stat::make('Paid', $paid)
                ->description("{$paidPercent}% of total orders")
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Pending', $pending)
                ->description("{$pendingPercent}% of total orders")
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Failed', $failed)
                ->description("{$failedPercent}% of total orders")
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('danger'),
        ];
    }
}

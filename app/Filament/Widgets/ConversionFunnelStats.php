<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Attributes\Reactive;

class ConversionFunnelStats extends BaseWidget
{
    use Concerns\AppliesDashboardFilters;

    #[Reactive]
    public ?array $pageFilters = null;

    protected ?string $heading = 'Order Conversion Funnel';

    protected int|string|array $columnSpan = 'full';

    protected ?string $pollingInterval = '20s';

    protected function getStats(): array
    {
        $query = $this->applyOrderFilters(Order::query());

        $totalOrders = $query->clone()->count();

        $pending = $query->clone()->where('order_status', 'Pending')->count();
        $confirmed = $query->clone()->where('order_status', 'Confirmed')->count();
        $processing = $query->clone()->where('order_status', 'Processing')->count();
        $shipped = $query->clone()->where('order_status', 'Shipped')->count();
        $delivered = $query->clone()->where('order_status', 'Delivered')->count();

        $funnelTotal = $pending + $confirmed + $processing + $shipped + $delivered;
        $pendingPct = $funnelTotal > 0 ? round(($pending / $funnelTotal) * 100, 1) : 0;
        $confirmedPct = $funnelTotal > 0 ? round(($confirmed / $funnelTotal) * 100, 1) : 0;
        $processingPct = $funnelTotal > 0 ? round(($processing / $funnelTotal) * 100, 1) : 0;
        $shippedPct = $funnelTotal > 0 ? round(($shipped / $funnelTotal) * 100, 1) : 0;
        $deliveredPct = $funnelTotal > 0 ? round(($delivered / $funnelTotal) * 100, 1) : 0;

        return [
            Stat::make('Total Orders', number_format($totalOrders))
                ->description('All orders in selected filters')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('gray'),
            Stat::make('Pending', $pending)
                ->description("{$pendingPct}% - Awaiting confirmation")
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Confirmed', $confirmed)
                ->description("{$confirmedPct}% - Order confirmed")
                ->descriptionIcon('heroicon-m-check')
                ->color('info'),
            Stat::make('Processing', $processing)
                ->description("{$processingPct}% - Being processed")
                ->descriptionIcon('heroicon-m-cog-6-tooth')
                ->color('primary'),
            Stat::make('Shipped', $shipped)
                ->description("{$shippedPct}% - In transit")
                ->descriptionIcon('heroicon-m-truck')
                ->color('secondary'),
            Stat::make('Delivered', $delivered)
                ->description("{$deliveredPct}% - Completed")
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}

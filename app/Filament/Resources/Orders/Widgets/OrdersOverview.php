<?php

namespace App\Filament\Resources\Orders\Widgets;

use App\Filament\Resources\Orders\Pages\ListOrders;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class OrdersOverview extends StatsOverviewWidget
{
    use InteractsWithPageTable;

    protected ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        $totalOrders = (clone $this->getPageTableQuery())->count();

        $last7DaysOrders = (clone $this->getPageTableQuery())
            ->whereDate('created_at', '>=', today()->subDays(6))
            ->count();

        $last30DaysOrders = (clone $this->getPageTableQuery())
            ->whereDate('created_at', '>=', today()->subDays(29))
            ->count();

        $last7DaysPreviousPeriodOrders = (clone $this->getPageTableQuery())
            ->whereBetween('created_at', [
                today()->subDays(13)->startOfDay(),
                today()->subDays(7)->endOfDay(),
            ])
            ->count();

        $last30DaysPreviousPeriodOrders = (clone $this->getPageTableQuery())
            ->whereBetween('created_at', [
                today()->subDays(59)->startOfDay(),
                today()->subDays(30)->endOfDay(),
            ])
            ->count();

        $last7DaysDelta = $this->calculateDeltaPercentage((float) $last7DaysOrders, (float) $last7DaysPreviousPeriodOrders);
        $last30DaysDelta = $this->calculateDeltaPercentage((float) $last30DaysOrders, (float) $last30DaysPreviousPeriodOrders);

        $ordersSeries7Days = $this->getOrderCountSeries(7);
        $ordersSeries30Days = $this->getOrderCountSeries(30);

        $cardClass = 'rounded-2xl bg-gray-900 text-white ring-1 ring-white/10';

        return [
            Stat::make('Orders', number_format($totalOrders))
                ->description('All-time orders count')
                ->chart($ordersSeries30Days)
                ->color('gray')
                ->extraAttributes([
                    'class' => $cardClass,
                ]),

            Stat::make('Last 7 Days Orders', number_format($last7DaysOrders))
                ->description(sprintf('%+.1f%% vs previous 7 days', $last7DaysDelta))
                ->chart($ordersSeries7Days)
                ->color('warning')
                ->extraAttributes([
                    'class' => $cardClass,
                ]),

            Stat::make('Last 30 Days Orders', number_format($last30DaysOrders))
                ->description(sprintf('%+.1f%% vs previous 30 days', $last30DaysDelta))
                ->chart($ordersSeries30Days)
                ->color('info')
                ->extraAttributes([
                    'class' => $cardClass,
                ]),
        ];
    }

    protected function getTablePage(): string
    {
        return ListOrders::class;
    }

    /**
     * @return array<int, int>
     */
    private function getOrderCountSeries(int $days): array
    {
        $start = Carbon::today()->subDays($days - 1);

        /** @var array<string, int> $rows */
        $rows = (clone $this->getPageTableQuery())
            ->reorder()
            ->whereDate('created_at', '>=', $start)
            ->selectRaw('DATE(created_at) as day')
            ->selectRaw('COUNT(*) as total_orders')
            ->groupBy('day')
            ->pluck('total_orders', 'day')
            ->all();

        $series = [];

        for ($date = $start->copy(); $date->lte(today()); $date->addDay()) {
            $series[] = (int) ($rows[$date->toDateString()] ?? 0);
        }

        return $series;
    }

    private function calculateDeltaPercentage(float $current, float $previous): float
    {
        if ($previous <= 0.0) {
            return $current > 0.0 ? 100.0 : 0.0;
        }

        return (($current - $previous) / $previous) * 100;
    }
}

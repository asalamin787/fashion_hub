<?php

namespace App\Filament\Widgets;

use App\Enums\PaymentStatus;
use App\Filament\Widgets\Concerns\AppliesDashboardFilters;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CommerceOverviewStats extends StatsOverviewWidget
{
    use AppliesDashboardFilters;
    use InteractsWithPageFilters;

    protected ?string $pollingInterval = '20s';

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $filteredOrders = $this->applyOrderFilters(Order::query());

        $totalOrders = (clone $filteredOrders)->count();
        $grossRevenue = (float) (clone $filteredOrders)->sum('total_amount');

        $paidOrdersQuery = (clone $filteredOrders)->where('payment_status', PaymentStatus::Paid->value);
        $paidOrders = $paidOrdersQuery->count();
        $paidRevenue = (float) (clone $paidOrdersQuery)->sum('total_amount');

        $averageOrderValue = $totalOrders > 0 ? $grossRevenue / $totalOrders : 0.0;
        $uniqueCustomers = (clone $filteredOrders)->distinct('customer_email')->count('customer_email');

        [$currentStart, $currentEnd] = $this->resolveDateRange();
        [$previousStart, $previousEnd] = $this->resolvePreviousDateRange();

        $previousOrderCount = Order::query()
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->count();

        $orderTrend = $this->calculateDeltaPercentage($totalOrders, $previousOrderCount);

        $newUsers = User::query()
            ->whereBetween('created_at', [$currentStart, $currentEnd])
            ->count();

        $activeProducts = Product::query()->where('status', 'active')->count();

        $lowStockProducts = Product::query()
            ->where('status', 'active')
            ->where('stock', '<=', 5)
            ->count();

        $revenueSeries = $this->getRevenueSeries();
        $ordersSeries = $this->getOrderSeries();

        $cardClass = 'rounded-2xl border border-white/10 bg-gradient-to-br from-[#1d2735] via-[#172235] to-[#151f2f] text-white shadow-sm';

        return [
            Stat::make('Gross Revenue', $this->formatCurrency($grossRevenue))
                ->description($this->getDateRangeLabel())
                ->chart($revenueSeries)
                ->color('success')
                ->extraAttributes(['class' => $cardClass]),

            Stat::make('Paid Revenue', $this->formatCurrency($paidRevenue))
                ->description('Confirmed paid amount')
                ->color('info')
                ->extraAttributes(['class' => $cardClass]),

            Stat::make('Orders', number_format($totalOrders))
                ->description(sprintf('%+.1f%% vs previous period', $orderTrend))
                ->chart($ordersSeries)
                ->color('warning')
                ->extraAttributes(['class' => $cardClass]),

            Stat::make('Paid Orders', number_format($paidOrders))
                ->description('Successfully paid orders')
                ->color('primary')
                ->extraAttributes(['class' => $cardClass]),

            Stat::make('Avg. Order Value', $this->formatCurrency($averageOrderValue))
                ->description('Revenue / total orders')
                ->color('gray')
                ->extraAttributes(['class' => $cardClass]),

            Stat::make('Customers', number_format($uniqueCustomers))
                ->description('Unique customers in period')
                ->color('success')
                ->extraAttributes(['class' => $cardClass]),

            Stat::make('New Users', number_format($newUsers))
                ->description('Registered during this period')
                ->color('info')
                ->extraAttributes(['class' => $cardClass]),

            Stat::make('Low Stock Products', number_format($lowStockProducts))
                ->description(sprintf('Active products: %s', number_format($activeProducts)))
                ->color($lowStockProducts > 0 ? 'danger' : 'success')
                ->extraAttributes(['class' => $cardClass]),
        ];
    }

    /**
     * @return array<int, int>
     */
    private function getOrderSeries(): array
    {
        [$startDate, $endDate] = $this->resolveDateRange();

        /** @var array<string, int> $dailyRows */
        $dailyRows = $this->applyOrderFilters(Order::query())
            ->reorder()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as day')
            ->selectRaw('COUNT(*) as total_orders')
            ->groupBy('day')
            ->pluck('total_orders', 'day')
            ->all();

        $series = [];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $series[] = (int) ($dailyRows[$date->toDateString()] ?? 0);
        }

        return $series;
    }

    /**
     * @return array<int, int>
     */
    private function getRevenueSeries(): array
    {
        [$startDate, $endDate] = $this->resolveDateRange();

        /** @var array<string, float|int|string> $dailyRows */
        $dailyRows = $this->applyOrderFilters(Order::query())
            ->reorder()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as day')
            ->selectRaw('SUM(total_amount) as total_revenue')
            ->groupBy('day')
            ->pluck('total_revenue', 'day')
            ->all();

        $series = [];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $series[] = (int) round((float) ($dailyRows[$date->toDateString()] ?? 0));
        }

        return $series;
    }

    private function formatCurrency(float $amount): string
    {
        return '$'.number_format($amount, 2);
    }

    private function calculateDeltaPercentage(int|float $current, int|float $previous): float
    {
        if ($previous <= 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return (($current - $previous) / $previous) * 100;
    }
}

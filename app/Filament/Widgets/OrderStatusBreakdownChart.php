<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatus;
use App\Filament\Widgets\Concerns\AppliesDashboardFilters;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class OrderStatusBreakdownChart extends ChartWidget
{
    use AppliesDashboardFilters;
    use InteractsWithPageFilters;

    protected ?string $heading = 'Order Status Breakdown';

    protected ?string $description = 'Distribution of order statuses for the selected period.';

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 3,
    ];

    protected ?string $maxHeight = '320px';

    protected function getType(): string
    {
        return 'doughnut';
    }

    /**
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        /** @var array<string, int> $rows */
        $rows = $this->applyOrderFilters(Order::query())
            ->selectRaw('order_status, COUNT(*) as total_orders')
            ->groupBy('order_status')
            ->pluck('total_orders', 'order_status')
            ->all();

        $labels = [];
        $values = [];
        $colors = [];

        foreach (OrderStatus::cases() as $status) {
            $count = (int) ($rows[$status->value] ?? 0);

            if ($count === 0) {
                continue;
            }

            $labels[] = $status->name;
            $values[] = $count;
            $colors[] = $this->statusColor($status);
        }

        if ($labels === []) {
            $labels = ['No data'];
            $values = [1];
            $colors = ['#CBD5E1'];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $values,
                    'backgroundColor' => $colors,
                    'hoverOffset' => 6,
                    'borderWidth' => 0,
                ],
            ],
            'labels' => $labels,
        ];
    }

    private function statusColor(OrderStatus $status): string
    {
        return match ($status) {
            OrderStatus::Pending => '#F59E0B',
            OrderStatus::Confirmed => '#38BDF8',
            OrderStatus::Processing => '#3B82F6',
            OrderStatus::Shipped => '#8B5CF6',
            OrderStatus::Delivered => '#22C55E',
            OrderStatus::Cancelled => '#EF4444',
            OrderStatus::Refunded => '#64748B',
        };
    }
}

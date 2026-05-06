<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\AppliesDashboardFilters;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class RevenueTrendChart extends ChartWidget
{
    use AppliesDashboardFilters;
    use InteractsWithPageFilters;

    protected ?string $heading = 'Revenue Trend';

    protected ?string $description = 'Daily revenue movement for the selected filters.';

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 3,
    ];

    protected ?string $maxHeight = '320px';

    protected function getType(): string
    {
        return 'line';
    }

    /**
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        [$startDate, $endDate] = $this->resolveDateRange();

        /** @var array<string, float|int|string> $rows */
        $rows = $this->applyOrderFilters(Order::query())
            ->reorder()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as day')
            ->selectRaw('SUM(total_amount) as total_revenue')
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at) ASC')
            ->pluck('total_revenue', 'day')
            ->all();

        $labels = [];
        $values = [];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $labels[] = $date->format('d M');
            $values[] = round((float) ($rows[$date->toDateString()] ?? 0), 2);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue (USD)',
                    'data' => $values,
                    'fill' => true,
                    'borderColor' => '#A76048',
                    'backgroundColor' => 'rgba(167, 96, 72, 0.20)',
                    'pointBackgroundColor' => '#C0876A',
                    'pointRadius' => 2.5,
                    'pointHoverRadius' => 4,
                    'tension' => 0.35,
                ],
            ],
            'labels' => $labels,
        ];
    }

    /**
     * @return array<string, mixed> | null
     */
    protected function getOptions(): ?array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'interaction' => [
                'intersect' => false,
                'mode' => 'index',
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}

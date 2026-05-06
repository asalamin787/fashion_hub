<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Reactive;

class CustomerGrowthTrendChart extends ChartWidget
{
    use Concerns\AppliesDashboardFilters;

    #[Reactive]
    public ?array $pageFilters = null;

    protected ?string $heading = 'Customer Growth Trend';

    protected ?string $description = 'New customer registrations over time';

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 3,
    ];

    protected ?string $maxHeight = '320px';

    public function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        [$startDate, $endDate] = $this->resolveDateRange();

        $data = User::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as day')
            ->selectRaw('COUNT(id) as total_customers')
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at) ASC')
            ->pluck('total_customers', 'day');

        if ($data->isEmpty()) {
            return [
                'labels' => ['No data'],
                'datasets' => [
                    [
                        'label' => 'New Customers',
                        'data' => [0],
                        'borderColor' => '#CBD5E1',
                        'backgroundColor' => 'rgba(203, 213, 225, 0.1)',
                    ],
                ],
            ];
        }

        $labels = $data->keys()->map(fn ($date) => Carbon::parse($date)->format('d M'))->toArray();
        $values = $data->values()->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'New Customers',
                    'data' => $values,
                    'borderColor' => '#A76048',
                    'backgroundColor' => 'rgba(167, 96, 72, 0.20)',
                    'tension' => 0.4,
                    'fill' => true,
                ],
            ],
        ];
    }

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

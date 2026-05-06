<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Livewire\Attributes\Reactive;

class OrderFulfillmentRateChart extends ChartWidget
{
    use Concerns\AppliesDashboardFilters;

    #[Reactive]
    public ?array $pageFilters = null;

    protected ?string $heading = 'Order Fulfillment Rate';

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 3,
    ];

    protected ?string $maxHeight = '320px';

    public function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $query = $this->applyOrderFilters(Order::query());

        $delivered = $query->clone()->where('order_status', 'Delivered')->count();
        $pending = $query->clone()
            ->whereIn('order_status', ['Pending', 'Confirmed', 'Processing', 'Shipped'])
            ->count();
        $other = $query->clone()
            ->whereIn('order_status', ['Cancelled', 'Refunded'])
            ->count();

        $total = $delivered + $pending + $other;

        if ($total === 0) {
            return [
                'labels' => ['No data'],
                'datasets' => [
                    [
                        'label' => 'Orders',
                        'data' => [1],
                        'backgroundColor' => ['#CBD5E1'],
                    ],
                ],
            ];
        }

        return [
            'labels' => ['Delivered', 'Pending', 'Cancelled/Refunded'],
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => [$delivered, $pending, $other],
                    'backgroundColor' => [
                        '#22C55E', // green - delivered
                        '#F59E0B', // amber - pending
                        '#EF4444', // red - cancelled/refunded
                    ],
                ],
            ],
        ];
    }
}

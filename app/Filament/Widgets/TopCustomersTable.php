<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseTableWidget;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Reactive;

class TopCustomersTable extends BaseTableWidget
{
    use Concerns\AppliesDashboardFilters;

    #[Reactive]
    public ?array $pageFilters = null;

    protected static ?string $heading = 'Top Customers';

    protected static ?string $description = 'Ranked by total spending';

    protected int|string|array $columnSpan = [
        'md' => 1,
        'xl' => 6,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTopCustomersQuery())
            ->columns([
                Tables\Columns\TextColumn::make('customer_email')
                    ->label('Customer Email')
                    ->searchable()
                    ->weight('600'),
                Tables\Columns\TextColumn::make('total_orders')
                    ->label('Orders')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_spent')
                    ->label('Total Spent')
                    ->money('USD', divideBy: 100)
                    ->sortable(),
            ])
            ->defaultSort('total_spent', 'desc')
            ->defaultKeySort(false)
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }

    private function getTopCustomersQuery(): Builder
    {
        return $this->applyOrderFilters(Order::query())
            ->selectRaw('MIN(id) as id')
            ->selectRaw('customer_email')
            ->selectRaw('COUNT(DISTINCT id) as total_orders')
            ->selectRaw('SUM(total_amount) as total_spent')
            ->groupBy('customer_email')
            ->orderByDesc('total_spent');
    }
}

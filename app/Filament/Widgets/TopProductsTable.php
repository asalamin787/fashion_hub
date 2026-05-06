<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\AppliesDashboardFilters;
use App\Models\OrderItem;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class TopProductsTable extends TableWidget
{
    use AppliesDashboardFilters;
    use InteractsWithPageFilters;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Top Selling Products')
            ->query($this->getTopProductsQuery())
            ->columns([
                TextColumn::make('product_name')
                    ->label('Product')
                    ->searchable()
                    ->weight('600')
                    ->wrap(),

                TextColumn::make('sold_qty')
                    ->label('Units Sold')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('total_orders')
                    ->label('Orders')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('gross_sales')
                    ->label('Gross Sales')
                    ->money('USD')
                    ->sortable(),
            ])
            ->defaultSort('sold_qty', 'desc')
            ->defaultKeySort(false)
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }

    protected function getTopProductsQuery(): Builder
    {
        $query = OrderItem::query()
            ->selectRaw('MIN(order_items.id) as id')
            ->selectRaw('order_items.product_id')
            ->selectRaw('MAX(order_items.product_name) as product_name')
            ->selectRaw('SUM(order_items.quantity) as sold_qty')
            ->selectRaw('COUNT(DISTINCT order_items.order_id) as total_orders')
            ->selectRaw('SUM(order_items.line_total) as gross_sales')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereNull('orders.deleted_at')
            ->groupBy('order_items.product_id')
            ->orderByDesc('sold_qty')
            ->orderByDesc('order_items.product_id');

        return $this->applyOrderFilters(
            query: $query,
            dateColumn: 'orders.created_at',
            orderStatusColumn: 'orders.order_status',
            paymentStatusColumn: 'orders.payment_status',
            paymentMethodColumn: 'orders.payment_method'
        );
    }
}

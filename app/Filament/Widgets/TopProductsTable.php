<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\AppliesDashboardFilters;
use App\Models\OrderItem;
use Filament\Tables\Columns\ImageColumn;
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
            ->description('Best-performing products based on quantity sold and revenue.')
            ->query($this->getTopProductsQuery())
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->circular()
                    ->size(40),

                TextColumn::make('product_name')
                    ->label('Product')
                    ->searchable()
                    ->weight('600')
                    ->description(fn ($record): ?string => $record->sku ?: null)
                    ->wrap(),

                TextColumn::make('sold_qty')
                    ->label('Units Sold')
                    ->numeric()
                    ->badge()
                    ->suffix(' pcs')
                    ->sortable(),

                TextColumn::make('total_orders')
                    ->label('Orders')
                    ->numeric()
                    ->icon('heroicon-m-shopping-bag')
                    ->sortable(),

                TextColumn::make('gross_sales')
                    ->label('Gross Sales')
                    ->money('USD')
                    ->weight('600')
                    ->sortable(),

                TextColumn::make('avg_order_value')
                    ->label('Avg / Order')
                    ->money('USD')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
            ])
            ->striped()
            ->defaultSort('sold_qty', 'desc')
            ->defaultKeySort(false)
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5)
            ->emptyStateHeading('No product sales found')
            ->emptyStateDescription('No order item data matched the selected dashboard filters.');
    }

    protected function getTopProductsQuery(): Builder
    {
        $query = OrderItem::query()
            ->selectRaw('MIN(order_items.id) as id')
            ->selectRaw('order_items.product_id')
            ->selectRaw('MAX(order_items.product_name) as product_name')
            ->selectRaw('MAX(order_items.sku) as sku')
            ->selectRaw('MAX(order_items.image) as image')
            ->selectRaw('SUM(order_items.quantity) as sold_qty')
            ->selectRaw('COUNT(DISTINCT order_items.order_id) as total_orders')
            ->selectRaw('SUM(order_items.line_total) as gross_sales')
            ->selectRaw('COALESCE(SUM(order_items.line_total) / NULLIF(COUNT(DISTINCT order_items.order_id), 0), 0) as avg_order_value')
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

<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseTableWidget;
use Illuminate\Database\Eloquent\Builder;

class LowStockAlertTable extends BaseTableWidget
{
    protected static ?string $heading = 'Low Stock Alert';

    protected static ?string $description = 'Products with stock ≤ 5 units';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getLowStockQuery())
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Image')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('name')
                    ->label('Product')
                    ->searchable()
                    ->weight('600')
                    ->wrap(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('stock')
                    ->label('Stock')
                    ->colors([
                        'danger' => fn ($state) => $state == 0,
                        'warning' => fn ($state) => $state > 0 && $state <= 2,
                        'info' => fn ($state) => $state > 2 && $state <= 5,
                    ])
                    ->formatStateUsing(fn ($state) => "{$state} units"),
                Tables\Columns\TextColumn::make('base_price')
                    ->label('Price')
                    ->money('USD'),
            ])
            ->defaultSort('stock', 'asc')
            ->paginated([10, 25, 50])
            ->defaultPaginationPageOption(10);
    }

    private function getLowStockQuery(): Builder
    {
        return Product::query()
            ->where('status', 'active')
            ->where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->select('id', 'featured_image', 'name', 'slug', 'stock', 'base_price');
    }
}

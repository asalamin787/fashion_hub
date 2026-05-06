<?php

namespace App\Filament\Widgets;

use App\Models\Coupon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseTableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CouponPerformanceTable extends BaseTableWidget
{
    protected static ?string $heading = 'Coupon Performance';

    protected static ?string $description = 'Top coupons by usage and revenue impact';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getCouponPerformanceQuery())
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Coupon Code')
                    ->searchable()
                    ->weight('600'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->colors([
                        'info' => 'percentage',
                        'success' => 'fixed',
                    ]),
                Tables\Columns\TextColumn::make('value')
                    ->label('Discount')
                    ->formatStateUsing(fn ($state, $record) => $record->type === 'percentage' ? "{$state}%" : '$'.number_format((float) $state, 2)),
                Tables\Columns\TextColumn::make('usage_count')
                    ->label('Used')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_discount')
                    ->label('Total Discount Given')
                    ->money('USD')
                    ->sortable(),
            ])
            ->defaultSort('usage_count', 'desc')
            ->paginated([10, 25, 50])
            ->defaultPaginationPageOption(10);
    }

    private function getCouponPerformanceQuery(): Builder
    {
        return Coupon::query()
            ->select('coupons.*')
            ->selectRaw('used_count as usage_count')
            ->addSelect(['total_discount' => fn ($q) => $q->select(DB::raw('COALESCE(SUM(discount_amount), 0)'))
                ->from('orders')
                ->whereColumn('orders.coupon_code', 'coupons.code'),
            ])
            ->orderByDesc('usage_count');
    }
}

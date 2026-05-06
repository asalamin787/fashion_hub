<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use BackedEnum;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget as BaseTableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentOrdersTable extends BaseTableWidget
{
    use Concerns\AppliesDashboardFilters;
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Recent Orders';

    protected static ?string $description = 'Latest orders with status and payment insights.';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getRecentOrdersQuery())
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->weight('600')
                    ->copyable(),
                Tables\Columns\TextColumn::make('customer_email')
                    ->label('Customer')
                    ->searchable()
                    ->icon('heroicon-m-envelope'),
                Tables\Columns\TextColumn::make('order_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => str($this->normalizeStateValue($state))->headline()->toString())
                    ->colors([
                        'warning' => fn ($state): bool => $this->normalizeStateValue($state) === 'pending',
                        'info' => fn ($state): bool => $this->normalizeStateValue($state) === 'confirmed',
                        'primary' => fn ($state): bool => $this->normalizeStateValue($state) === 'processing',
                        'secondary' => fn ($state): bool => $this->normalizeStateValue($state) === 'shipped',
                        'success' => fn ($state): bool => $this->normalizeStateValue($state) === 'delivered',
                        'danger' => fn ($state): bool => in_array($this->normalizeStateValue($state), ['cancelled', 'refunded'], true),
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Payment')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => str($this->normalizeStateValue($state))->headline()->toString())
                    ->colors([
                        'success' => fn ($state): bool => $this->normalizeStateValue($state) === 'paid',
                        'warning' => fn ($state): bool => in_array($this->normalizeStateValue($state), ['pending', 'authorized'], true),
                        'danger' => fn ($state): bool => in_array($this->normalizeStateValue($state), ['failed', 'cancelled'], true),
                        'gray' => fn ($state): bool => in_array($this->normalizeStateValue($state), ['unpaid', 'refunded', 'partially_refunded'], true),
                    ])
                    ->toggleable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Method')
                    ->formatStateUsing(fn ($state): string => str($this->normalizeStateValue($state))->headline()->toString())
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Amount')
                    ->money('USD')
                    ->sortable()
                    ->weight('600'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->striped()
            ->defaultSort('created_at', 'desc')
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }

    private function getRecentOrdersQuery(): Builder
    {
        return $this->applyOrderFilters(Order::query())
            ->orderByDesc('created_at')
            ->select('id', 'order_number', 'customer_email', 'order_status', 'payment_status', 'payment_method', 'total_amount', 'created_at');
    }

    private function normalizeStateValue(mixed $state): string
    {
        if ($state instanceof BackedEnum) {
            return (string) $state->value;
        }

        return (string) $state;
    }
}

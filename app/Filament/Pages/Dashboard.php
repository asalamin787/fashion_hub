<?php

namespace App\Filament\Pages;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Filament\Widgets\CommerceOverviewStats;
use App\Filament\Widgets\OrderStatusBreakdownChart;
use App\Filament\Widgets\RevenueTrendChart;
use App\Filament\Widgets\TopProductsTable;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    protected static ?string $title = 'Commerce Dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    /**
     * @return int | array<string, int | null>
     */
    public function getColumns(): int|array
    {
        return [
            'md' => 2,
            'xl' => 6,
        ];
    }

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Live dashboard filters')
                    ->description('Apply period and status filters to all dashboard widgets instantly.')
                    ->compact()
                    ->columns([
                        'md' => 2,
                        'xl' => 4,
                    ])
                    ->schema([
                        Select::make('period')
                            ->label('Period')
                            ->options([
                                'today' => 'Today',
                                '7d' => 'Last 7 days',
                                '30d' => 'Last 30 days',
                                '90d' => 'Last 90 days',
                                'ytd' => 'Year to date',
                                'custom' => 'Custom range',
                            ])
                            ->default('30d')
                            ->native(false)
                            ->live(),

                        DatePicker::make('startDate')
                            ->label('Start date')
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->visible(fn (Get $get): bool => $get('period') === 'custom'),

                        DatePicker::make('endDate')
                            ->label('End date')
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->visible(fn (Get $get): bool => $get('period') === 'custom'),

                        Select::make('orderStatus')
                            ->label('Order status')
                            ->placeholder('All statuses')
                            ->options(collect(OrderStatus::cases())->mapWithKeys(fn (OrderStatus $status): array => [
                                $status->value => $status->name,
                            ])->all())
                            ->native(false),

                        Select::make('paymentStatus')
                            ->label('Payment status')
                            ->placeholder('All payment statuses')
                            ->options(collect(PaymentStatus::cases())->mapWithKeys(fn (PaymentStatus $status): array => [
                                $status->value => $status->name,
                            ])->all())
                            ->native(false),

                        Select::make('paymentMethod')
                            ->label('Payment method')
                            ->placeholder('All payment methods')
                            ->options(collect(PaymentMethod::cases())->mapWithKeys(fn (PaymentMethod $method): array => [
                                $method->value => match ($method) {
                                    PaymentMethod::CreditCard => 'Credit Card',
                                    PaymentMethod::GooglePay => 'Google Pay',
                                    PaymentMethod::Paypal => 'PayPal',
                                    PaymentMethod::CashOnDelivery => 'Cash on Delivery',
                                },
                            ])->all())
                            ->native(false),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    /**
     * @return array<class-string>
     */
    public function getWidgets(): array
    {
        return [
            CommerceOverviewStats::class,
            RevenueTrendChart::class,
            OrderStatusBreakdownChart::class,
            TopProductsTable::class,
        ];
    }
}

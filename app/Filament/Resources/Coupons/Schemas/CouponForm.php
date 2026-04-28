<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Coupon workspace')
                    ->description('Create and manage discount coupons from a guided tabbed workflow.')
                    ->icon(Heroicon::Tag)
                    ->components([
                        Tabs::make('Coupon tabs')
                            ->persistTabInQueryString('coupon-tab')
                            ->tabs([
                                Tab::make('Details')
                                    ->icon(Heroicon::Identification)
                                    ->columns([
                                        'default' => 1,
                                        'md' => 3,
                                    ])
                                    ->components([
                                        TextInput::make('name')
                                            ->label('Coupon name')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('New Year Offer')
                                            ->columnSpanFull(),
                                        TextInput::make('code')
                                            ->label('Coupon code')
                                            ->required()
                                            ->maxLength(100)
                                            ->unique(ignoreRecord: true)
                                            ->dehydrateStateUsing(fn(?string $state): string => mb_strtoupper(trim((string) $state)))
                                            ->placeholder('NEWYEAR50'),

                                        TextInput::make('usage_limit')
                                            ->label('Usage limit')
                                            ->numeric()
                                            ->minValue(1)
                                            ->placeholder('Leave blank for unlimited')
                                            ->helperText('How many times this coupon can be used globally.'),
                                        TextInput::make('used_count')
                                            ->label('Used count')
                                            ->numeric()
                                            ->default(0)
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->helperText('Auto-managed by the system.'),

                                        Toggle::make('is_active')
                                            ->label('Active coupon')
                                            ->default(true)
                                            ->columnSpanFull(),
                                    ]),
                                Tab::make('Discount')
                                    ->icon(Heroicon::Banknotes)
                                    ->columns([
                                        'default' => 1,
                                        'md' => 3,
                                    ])
                                    ->components([
                                        Select::make('type')
                                            ->label('Discount type')
                                            ->required()
                                            ->native(false)
                                            ->default('percentage')
                                            ->live()
                                            ->options([
                                                'percentage' => 'Percentage (%)',
                                                'fixed' => 'Fixed amount ($)',
                                            ]),
                                        TextInput::make('value')
                                            ->label(fn(Get $get): string => $get('type') === 'percentage' ? 'Discount (%)' : 'Discount amount ($)')
                                            ->required()
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->minValue(0.01)
                                            ->placeholder(fn(Get $get): string => $get('type') === 'percentage' ? '10' : '100.00'),
                                        TextInput::make('max_discount_amount')
                                            ->label('Max discount cap ($)')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->minValue(0)
                                            ->placeholder('500.00')
                                            ->visible(fn(Get $get): bool => $get('type') === 'percentage'),
                                        TextInput::make('min_order_amount')
                                            ->label('Minimum order amount ($)')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->minValue(0)
                                            ->placeholder('500.00')
                                            ->helperText('Coupon applies only when cart subtotal reaches this amount.')
                                            ->columnSpan([
                                                'default' => 1,
                                                'md' => 3,
                                            ]),
                                    ]),
                                Tab::make('Validity')
                                    ->icon(Heroicon::Calendar)
                                    ->columns([
                                        'default' => 1,
                                        'md' => 2,
                                    ])
                                    ->components([
                                        DateTimePicker::make('starts_at')
                                            ->label('Starts at')
                                            ->native(false)
                                            ->placeholder('Starts immediately if empty'),
                                        DateTimePicker::make('expires_at')
                                            ->label('Expires at')
                                            ->native(false)
                                            ->placeholder('No expiry if empty')
                                            ->after('starts_at'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Offers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class OfferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Offer Details')
                    ->description('Configure discount type, value, validity period, and the products this offer applies to.')
                    ->icon(Heroicon::Tag)
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->components([
                        TextInput::make('title')
                            ->label('Offer title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Summer Sale 50% Off')
                            ->columnSpanFull(),
                        TextInput::make('code')
                            ->label('Coupon code')
                            ->maxLength(100)
                            ->placeholder('SUMMER50')
                            ->helperText('Leave blank for automatic offers (no code required).')
                            ->unique(ignoreRecord: true),
                        Toggle::make('is_active')
                            ->label('Active offer')
                            ->default(true),
                        Textarea::make('description')
                            ->rows(3)
                            ->placeholder('Short description of the offer.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                Section::make('Discount Configuration')
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
                                'fixed' => 'Fixed amount (৳)',
                            ]),
                        TextInput::make('value')
                            ->label(fn (Get $get): string => $get('type') === 'percentage' ? 'Discount (%)' : 'Discount amount (৳)')
                            ->required()
                            ->numeric()
                            ->inputMode('decimal')
                            ->minValue(0.01)
                            ->placeholder(fn (Get $get): string => $get('type') === 'percentage' ? '10' : '100.00'),
                        TextInput::make('max_discount_amount')
                            ->label('Max discount cap (৳)')
                            ->numeric()
                            ->inputMode('decimal')
                            ->minValue(0)
                            ->placeholder('500.00')
                            ->helperText('Caps maximum discount for percentage offers.')
                            ->visible(fn (Get $get): bool => $get('type') === 'percentage'),
                        TextInput::make('min_order_amount')
                            ->label('Minimum order amount (৳)')
                            ->numeric()
                            ->inputMode('decimal')
                            ->minValue(0)
                            ->placeholder('500.00')
                            ->helperText('Offer only applies if cart total exceeds this amount.'),
                    ])
                    ->columnSpanFull(),

                Section::make('Validity Period')
                    ->icon(Heroicon::Calendar)
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->components([
                        DateTimePicker::make('starts_at')
                            ->label('Starts at')
                            ->native(false)
                            ->placeholder('Leave blank to start immediately'),
                        DateTimePicker::make('expires_at')
                            ->label('Expires at')
                            ->native(false)
                            ->placeholder('Leave blank for no expiry')
                            ->after('starts_at'),
                    ])
                    ->columnSpanFull(),

                Section::make('Applicable Products')
                    ->description('Select which products this offer applies to. Leave empty to apply to all products.')
                    ->icon(Heroicon::ShoppingBag)
                    ->components([
                        Select::make('products')
                            ->label('Products')
                            ->relationship('products', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->helperText('Leave empty to apply to all active products.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CouponInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Coupon Overview')
                    ->icon(Heroicon::Tag)
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->components([
                        TextEntry::make('name')
                            ->label('Coupon name'),
                        TextEntry::make('code')
                            ->label('Coupon code')
                            ->badge()
                            ->color('warning')
                            ->copyable(),
                        TextEntry::make('type')
                            ->label('Discount type')
                            ->badge()
                            ->color(fn (string $state): string => $state === 'percentage' ? 'info' : 'success')
                            ->formatStateUsing(fn (string $state): string => $state === 'percentage' ? 'Percentage (%)' : 'Fixed amount ($)'),
                        TextEntry::make('formatted_value')
                            ->label('Discount value'),
                        TextEntry::make('min_order_amount')
                            ->label('Minimum order ($)')
                            ->placeholder('No minimum')
                            ->formatStateUsing(fn (?string $state): string => $state !== null ? number_format((float) $state, 2) : 'No minimum'),
                        TextEntry::make('max_discount_amount')
                            ->label('Max discount cap ($)')
                            ->placeholder('No cap')
                            ->formatStateUsing(fn (?string $state): string => $state !== null ? number_format((float) $state, 2) : 'No cap'),
                        TextEntry::make('usage_limit')
                            ->label('Usage limit')
                            ->placeholder('Unlimited'),
                        TextEntry::make('used_count')
                            ->label('Used count')
                            ->badge()
                            ->color('gray'),
                        IconEntry::make('is_active')
                            ->label('Active')
                            ->boolean(),
                        TextEntry::make('starts_at')
                            ->label('Starts at')
                            ->dateTime('d M Y, h:i A')
                            ->placeholder('Immediately'),
                        TextEntry::make('expires_at')
                            ->label('Expires at')
                            ->dateTime('d M Y, h:i A')
                            ->placeholder('No expiry'),
                        TextEntry::make('created_at')
                            ->label('Created')
                            ->dateTime('d M Y, h:i A'),
                        TextEntry::make('updated_at')
                            ->label('Last updated')
                            ->dateTime('d M Y, h:i A'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

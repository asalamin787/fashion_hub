<?php

namespace App\Filament\Resources\Offers\Schemas;

use App\Models\Offer;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class OfferInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Offer overview')
                    ->icon(Heroicon::Tag)
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->components([
                        TextEntry::make('title')
                            ->label('Offer title'),
                        TextEntry::make('code')
                            ->label('Coupon code')
                            ->badge()
                            ->color('warning')
                            ->copyable()
                            ->placeholder('No code (automatic)'),
                        TextEntry::make('type')
                            ->label('Discount type')
                            ->badge()
                            ->color(fn (string $state): string => $state === 'percentage' ? 'info' : 'success')
                            ->formatStateUsing(fn (string $state): string => $state === 'percentage' ? 'Percentage (%)' : 'Fixed amount (৳)'),
                        TextEntry::make('formatted_value')
                            ->label('Discount value'),
                        TextEntry::make('min_order_amount')
                            ->label('Min order (৳)')
                            ->placeholder('No minimum')
                            ->formatStateUsing(fn (?string $state): string => $state !== null ? number_format((float) $state, 2) : 'No minimum'),
                        TextEntry::make('max_discount_amount')
                            ->label('Max discount cap (৳)')
                            ->placeholder('No cap')
                            ->formatStateUsing(fn (?string $state): string => $state !== null ? number_format((float) $state, 2) : 'No cap'),
                        IconEntry::make('is_active')
                            ->label('Active')
                            ->boolean(),
                        TextEntry::make('products_count')
                            ->label('Products')
                            ->state(fn (Offer $record): string => (string) $record->products()->count())
                            ->badge()
                            ->color('info'),
                        TextEntry::make('starts_at')
                            ->label('Starts at')
                            ->dateTime('d M Y, h:i A')
                            ->placeholder('Immediately'),
                        TextEntry::make('expires_at')
                            ->label('Expires at')
                            ->dateTime('d M Y, h:i A')
                            ->placeholder('No expiry'),
                        TextEntry::make('description')
                            ->placeholder('No description.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

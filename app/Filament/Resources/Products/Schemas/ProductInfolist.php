<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Icons\Heroicon;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product overview')
                    ->icon(Heroicon::ShoppingBag)
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->components([
                        ImageEntry::make('featured_image')
                            ->label('Featured image')
                            ->disk('public')
                            ->columnSpanFull(),
                        TextEntry::make('name')
                            ->label('Product name'),
                        TextEntry::make('slug')
                            ->copyable(),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'active' => 'success',
                                'inactive' => 'danger',
                                default => 'warning',
                            }),
                        IconEntry::make('has_variants')
                            ->label('Has variants')
                            ->boolean(),
                        TextEntry::make('price_range_label')
                            ->label('Price range')
                            ->state(function (Product $record): string {
                                $range = $record->price_range;

                                if (! is_array($range)) {
                                    return 'Not set';
                                }

                                $min = number_format((float) $range['min'], 2);
                                $max = number_format((float) $range['max'], 2);

                                return $min === $max ? $min : $min.' - '.$max;
                            }),
                        TextEntry::make('short_description')
                            ->placeholder('No short description added.')
                            ->columnSpanFull(),
                        TextEntry::make('description')
                            ->placeholder('No long description added.')
                            ->columnSpanFull(),
                        TextEntry::make('updated_at')
                            ->dateTime('d M Y, h:i A'),
                    ])
                    ->columnSpanFull(),
                Section::make('Attributes')
                    ->icon(Heroicon::Swatch)
                    ->components([
                        RepeatableEntry::make('attribute_display_rows')
                            ->contained(false)
                            ->grid([
                                'default' => 1,
                                'md' => 2,
                            ])
                            ->schema([
                                TextEntry::make('name')
                                    ->weight('bold'),
                                TextEntry::make('slug')
                                    ->badge(),
                                TextEntry::make('display_type')
                                    ->badge(),
                                TextEntry::make('values_label')
                                    ->label('Values')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
                Section::make('Variants')
                    ->icon(Heroicon::SquaresPlus)
                    ->components([
                        RepeatableEntry::make('variant_display_rows')
                            ->contained(false)
                            ->table([
                                TableColumn::make('Combination')
                                    ->wrapHeader(),
                                TableColumn::make('SKU'),
                                TableColumn::make('Price')
                                    ->alignment(Alignment::End),
                                TableColumn::make('Stock')
                                    ->alignment(Alignment::Center),
                                TableColumn::make('Status')
                                    ->alignment(Alignment::Center),
                            ])
                            ->schema([
                                TextEntry::make('combination_label')
                                    ->label('Combination'),
                                TextEntry::make('sku'),
                                TextEntry::make('price')
                                    ->formatStateUsing(fn (?string $state): string => $state !== null ? number_format((float) $state, 2) : '-'),
                                TextEntry::make('stock'),
                                TextEntry::make('status')
                                    ->badge(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

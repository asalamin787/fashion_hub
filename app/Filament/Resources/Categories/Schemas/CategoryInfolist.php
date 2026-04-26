<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Category Overview')
                    ->icon(Heroicon::Tag)
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->components([
                        ImageEntry::make('image')
                            ->label('Category Image')
                            ->disk('public')
                            ->circular()
                            ->columnSpanFull(),
                        TextEntry::make('name')
                            ->label('Category name'),
                        TextEntry::make('products_count')
                            ->label('Total products')
                            ->state(fn ($record): int => $record->products()->count())
                            ->badge()
                            ->color('primary'),
                        TextEntry::make('slug')
                            ->copyable(),
                        IconEntry::make('is_active')
                            ->label('Status')
                            ->boolean(),
                        TextEntry::make('sort_order')
                            ->badge(),
                        TextEntry::make('description')
                            ->placeholder('No description added.')
                            ->columnSpanFull(),
                        TextEntry::make('product_preview')
                            ->label('Recent products')
                            ->state(function ($record): string {
                                $productNames = $record->products()
                                    ->latest('id')
                                    ->limit(5)
                                    ->pluck('name')
                                    ->all();

                                return empty($productNames) ? 'No products added in this category yet.' : implode(', ', $productNames);
                            })
                            ->columnSpanFull(),
                        TextEntry::make('created_at')
                            ->dateTime('d M Y, h:i A'),
                        TextEntry::make('updated_at')
                            ->dateTime('d M Y, h:i A'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

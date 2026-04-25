<?php

namespace App\Filament\Resources\Bags\Schemas;

use App\Models\Bag;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class BagInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Bag overview')
                    ->icon(Heroicon::ShoppingCart)
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->components([
                        TextEntry::make('name')
                            ->label('Bag name'),
                        TextEntry::make('slug')
                            ->copyable()
                            ->badge()
                            ->color('gray'),
                        IconEntry::make('is_active')
                            ->label('Active')
                            ->boolean(),
                        TextEntry::make('products_count')
                            ->label('Products')
                            ->state(fn (Bag $record): string => (string) $record->products()->count())
                            ->badge()
                            ->color('info'),
                        TextEntry::make('description')
                            ->placeholder('No description added.')
                            ->columnSpanFull(),
                        TextEntry::make('updated_at')
                            ->dateTime('d M Y, h:i A'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

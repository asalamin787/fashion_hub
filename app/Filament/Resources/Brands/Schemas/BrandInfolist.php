<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class BrandInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Brand Overview')
                    ->icon(Heroicon::Tag)
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->components([
                        ImageEntry::make('logo')
                            ->label('Brand logo')
                            ->disk('public')
                            ->circular()
                            ->placeholder('No logo')
                            ->columnSpanFull(),
                        TextEntry::make('name')
                            ->label('Brand name'),
                        TextEntry::make('slug')
                            ->copyable(),
                        TextEntry::make('website')
                            ->url(fn ($state) => $state)
                            ->openUrlInNewTab()
                            ->placeholder('No website set'),
                        IconEntry::make('is_active')
                            ->label('Status')
                            ->boolean(),
                        TextEntry::make('sort_order')
                            ->badge(),
                        TextEntry::make('description')
                            ->placeholder('No description added.')
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

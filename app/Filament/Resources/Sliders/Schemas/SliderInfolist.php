<?php

namespace App\Filament\Resources\Sliders\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SliderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Slider overview')
                    ->icon(Heroicon::Photo)
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->components([
                        ImageEntry::make('background_image')
                            ->label('Background image')
                            ->disk('public')
                            ->columnSpanFull(),
                        TextEntry::make('subtitle')
                            ->placeholder('No subtitle'),
                        TextEntry::make('title')
                            ->weight('bold'),
                        TextEntry::make('description')
                            ->placeholder('No description')
                            ->columnSpanFull(),
                        TextEntry::make('primary_button_text')
                            ->label('Primary button'),
                        TextEntry::make('primary_button_link')
                            ->label('Primary link')
                            ->placeholder('/shop'),
                        TextEntry::make('secondary_button_text')
                            ->label('Secondary button'),
                        TextEntry::make('secondary_button_link')
                            ->label('Secondary link')
                            ->placeholder('/blog'),
                        TextEntry::make('sort_order')
                            ->badge(),
                        IconEntry::make('is_active')
                            ->label('Active')
                            ->boolean(),
                        TextEntry::make('updated_at')
                            ->dateTime('d M Y, h:i A'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

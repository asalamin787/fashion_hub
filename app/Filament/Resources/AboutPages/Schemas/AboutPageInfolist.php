<?php

namespace App\Filament\Resources\AboutPages\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AboutPageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Overview')
                    ->icon(Heroicon::InformationCircle)
                    ->columns(2)
                    ->components([
                        TextEntry::make('hero_title')->weight('bold'),
                        TextEntry::make('hero_subtitle'),
                        TextEntry::make('story_title'),
                        ImageEntry::make('story_image')
                            ->disk('public')
                            ->columnSpanFull(),
                        TextEntry::make('values_title'),
                        TextEntry::make('team_title'),
                        TextEntry::make('sort_order')->badge(),
                        IconEntry::make('is_active')->boolean(),
                        TextEntry::make('updated_at')->dateTime('d M Y, h:i A'),
                    ]),
            ]);
    }
}

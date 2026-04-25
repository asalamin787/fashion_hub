<?php

namespace App\Filament\Resources\InstagramFeeds\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class InstagramFeedInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Instagram feed overview')
                    ->icon(Heroicon::Photo)
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->components([
                        ImageEntry::make('image')
                            ->label('Image')
                            ->disk('public')
                            ->columnSpanFull(),
                        TextEntry::make('section_title')
                            ->weight('bold'),
                        TextEntry::make('instagram_handle')
                            ->badge()
                            ->color('info'),
                        TextEntry::make('post_url')
                            ->placeholder('No link')
                            ->url(fn (?string $state): ?string => $state),
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

<?php

namespace App\Filament\Resources\InstagramFeeds\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class InstagramFeedForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Instagram Feed Content')
                    ->description('Manage the Follow Us on Instagram title, handle, image, and post link.')
                    ->icon(Heroicon::Photo)
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->components([
                        TextInput::make('section_title')
                            ->required()
                            ->maxLength(255)
                            ->default('Follow Us on Instagram')
                            ->placeholder('Follow Us on Instagram')
                            ->columnSpanFull(),
                        TextInput::make('instagram_handle')
                            ->required()
                            ->maxLength(255)
                            ->default('@fashionhub')
                            ->placeholder('@fashionhub'),
                        TextInput::make('post_url')
                            ->label('Post link')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://instagram.com/p/xyz...'),
                        FileUpload::make('image')
                            ->label('Post image')
                            ->required()
                            ->image()
                            ->imageEditor()
                            ->directory('instagram')
                            ->disk('public')
                            ->visibility('public')
                            ->columnSpanFull(),
                        TextInput::make('sort_order')
                            ->label('Sort order')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        Toggle::make('is_active')
                            ->label('Active post')
                            ->default(true),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

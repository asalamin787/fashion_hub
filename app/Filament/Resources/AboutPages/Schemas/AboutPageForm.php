<?php

namespace App\Filament\Resources\AboutPages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AboutPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('About Page Tabs')
                    ->persistTabInQueryString('about-tab')
                    ->tabs([
                        Tab::make('Hero')
                            ->icon(Heroicon::InformationCircle)
                            ->components([
                                Section::make('Hero Section')
                                    ->columns(2)
                                    ->components([
                                        TextInput::make('hero_title')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                        TextInput::make('hero_subtitle')
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Our Story')
                            ->icon(Heroicon::BookOpen)
                            ->components([
                                Section::make('Story Section')
                                    ->columns(2)
                                    ->components([
                                        TextInput::make('story_title')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                        Textarea::make('story_body')
                                            ->rows(8)
                                            ->helperText('Use one line per paragraph.')
                                            ->columnSpanFull(),
                                        FileUpload::make('story_image')
                                            ->image()
                                            ->imageEditor()
                                            ->directory('about')
                                            ->disk('public')
                                            ->visibility('public')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Values')
                            ->icon(Heroicon::Heart)
                            ->components([
                                Section::make('Values Section')
                                    ->columns(2)
                                    ->components([
                                        TextInput::make('values_title')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('values_subtitle')
                                            ->maxLength(255),
                                        Repeater::make('values_items')
                                            ->label('Values')
                                            ->schema([
                                                TextInput::make('icon')
                                                    ->maxLength(100)
                                                    ->placeholder('fas fa-gem')
                                                    ->required(),
                                                TextInput::make('title')
                                                    ->maxLength(255)
                                                    ->required(),
                                                Textarea::make('description')
                                                    ->rows(3)
                                                    ->required(),
                                            ])
                                            ->defaultItems(3)
                                            ->reorderable()
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Team')
                            ->icon(Heroicon::UserGroup)
                            ->components([
                                Section::make('Team Section')
                                    ->columns(2)
                                    ->components([
                                        TextInput::make('team_title')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('team_subtitle')
                                            ->maxLength(255),
                                        Repeater::make('team_members')
                                            ->label('Team Members')
                                            ->schema([
                                                TextInput::make('name')
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('role')
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('image')
                                                    ->label('Image URL')
                                                    ->required()
                                                    ->maxLength(500),
                                                TextInput::make('linkedin')
                                                    ->maxLength(500),
                                                TextInput::make('twitter')
                                                    ->maxLength(500),
                                                TextInput::make('instagram')
                                                    ->maxLength(500),
                                            ])
                                            ->defaultItems(4)
                                            ->reorderable()
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Stats')
                            ->icon(Heroicon::ChartBar)
                            ->components([
                                Section::make('Stats Section')
                                    ->components([
                                        Repeater::make('stats_items')
                                            ->label('Stats')
                                            ->schema([
                                                TextInput::make('value')
                                                    ->required()
                                                    ->maxLength(50),
                                                TextInput::make('label')
                                                    ->required()
                                                    ->maxLength(255),
                                            ])
                                            ->defaultItems(4)
                                            ->reorderable()
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Settings')
                            ->icon(Heroicon::Cog6Tooth)
                            ->components([
                                Section::make('Visibility')
                                    ->columns(2)
                                    ->components([
                                        Toggle::make('is_active')
                                            ->default(true)
                                            ->label('Active page'),
                                        TextInput::make('sort_order')
                                            ->numeric()
                                            ->default(0)
                                            ->minValue(0),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

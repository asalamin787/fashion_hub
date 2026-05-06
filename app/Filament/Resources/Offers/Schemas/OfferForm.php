<?php

namespace App\Filament\Resources\Offers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class OfferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Offer workspace')
                    ->description('Create and manage offers using a guided tabbed workflow.')
                    ->icon(Heroicon::Tag)
                    ->components([
                        Tabs::make('Offer tabs')
                            ->persistTabInQueryString('offer-tab')
                            ->tabs([
                                Tab::make('Offer Details')
                                    ->icon(Heroicon::Tag)
                                    ->columns([
                                        'default' => 1,
                                        'md' => 2,
                                    ])
                                    ->components([
                                        TextInput::make('title')
                                            ->label('Offer title')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Summer Sale 50% Off')
                                            ->columnSpanFull(),

                                        Textarea::make('description')
                                            ->rows(3)
                                            ->placeholder('Short description of the offer.')
                                            ->columnSpanFull(),

                                        FileUpload::make('image')
                                            ->label('Offer banner image')
                                            ->image()
                                            ->imageEditor()
                                            ->disk('public')
                                            ->directory('offers')
                                            ->visibility('public')
                                            ->maxSize(2048)
                                            ->helperText('Upload banner image for homepage promotional blocks.')
                                            ->columnSpanFull(),

                                        Toggle::make('is_active')
                                            ->label('Active offer')
                                            ->default(true),
                                    ]),

                                Tab::make('Validity Period')
                                    ->icon(Heroicon::Calendar)
                                    ->columns([
                                        'default' => 1,
                                        'md' => 2,
                                    ])
                                    ->components([
                                        DateTimePicker::make('starts_at')
                                            ->label('Starts at')
                                            ->native(false)
                                            ->placeholder('Leave blank to start immediately'),

                                        DateTimePicker::make('expires_at')
                                            ->label('Expires at')
                                            ->native(false)
                                            ->placeholder('Leave blank for no expiry')
                                            ->after('starts_at'),
                                    ]),

                                Tab::make('Applicable Products')
                                    ->icon(Heroicon::ShoppingBag)
                                    ->columns([
                                        'default' => 1,
                                    ])
                                    ->components([
                                        Select::make('products')
                                            ->label('Products')
                                            ->relationship('products', 'name')
                                            ->multiple()
                                            ->searchable()
                                            ->preload()
                                            ->native(false)
                                            ->helperText('Leave empty to apply to all active products.')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

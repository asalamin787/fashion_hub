<?php

namespace App\Filament\Resources\Sliders\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SliderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Slider Content')
                    ->description('Add homepage hero slider title, description, image, and button links.')
                    ->icon(Heroicon::Photo)
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->components([
                        TextInput::make('subtitle')
                            ->label('Subtitle')
                            ->maxLength(255)
                            ->placeholder('Summer Collection')
                            ->columnSpanFull(),
                        TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Up to 50% Off')
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->rows(4)
                            ->placeholder('Limited time offer on selected summer fashion items.')
                            ->columnSpanFull(),
                        FileUpload::make('background_image')
                            ->label('Background image')
                            ->image()
                            ->imageEditor()
                            ->directory('sliders')
                            ->disk('public')
                            ->visibility('public')
                            ->helperText('Upload a hero-sized image for best results.')
                            ->columnSpanFull(),
                        TextInput::make('primary_button_text')
                            ->label('Primary button text')
                            ->maxLength(100)
                            ->placeholder('Shop Sale'),
                        TextInput::make('primary_button_link')
                            ->label('Primary button link')
                            ->maxLength(255)
                            ->placeholder('/shop'),
                        TextInput::make('secondary_button_text')
                            ->label('Secondary button text')
                            ->maxLength(100)
                            ->placeholder('View Collection'),
                        TextInput::make('secondary_button_link')
                            ->label('Secondary button link')
                            ->maxLength(255)
                            ->placeholder('/blog'),
                        TextInput::make('sort_order')
                            ->label('Sort order')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        Toggle::make('is_active')
                            ->label('Active slider')
                            ->default(true),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

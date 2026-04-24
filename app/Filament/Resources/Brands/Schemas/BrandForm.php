<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Brand Details')
                    ->description('Manage the brand identity, URL slug, logo, and storefront visibility.')
                    ->icon(Heroicon::Tag)
                    ->columns([
                        'default' => 1,
                        'md' => 3,
                    ])
                    ->components([
                        TextInput::make('name')
                            ->label('Brand name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('FashionHub Premium')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, ?string $old, callable $set, callable $get): void {
                                $currentSlug = (string) $get('slug');
                                $oldSlug = Str::slug((string) $old);

                                if (blank($currentSlug) || ($currentSlug === $oldSlug)) {
                                    $set('slug', Str::slug((string) $state));
                                }
                            })
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('fashionhub-premium')
                            ->unique(ignoreRecord: true),
                        TextInput::make('website')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://example.com'),
                        TextInput::make('sort_order')
                            ->label('Sort order')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        Toggle::make('is_active')
                            ->label('Active brand')
                            ->default(true)
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->rows(4)
                            ->placeholder('Short brand description for merchandising and filters.')
                            ->columnSpanFull(),
                        FileUpload::make('logo')
                            ->label('Brand logo')
                            ->image()
                            ->imageEditor()
                            ->directory('brands')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

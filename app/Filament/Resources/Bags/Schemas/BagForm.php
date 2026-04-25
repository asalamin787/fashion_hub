<?php

namespace App\Filament\Resources\Bags\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class BagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Bag Details')
                    ->description('Create or update a product bag to group related products together.')
                    ->icon(Heroicon::ShoppingCart)
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->components([
                        TextInput::make('name')
                            ->label('Bag name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Summer Collection')
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
                            ->placeholder('summer-collection')
                            ->unique(ignoreRecord: true),
                        Toggle::make('is_active')
                            ->label('Active bag')
                            ->default(true),
                        Textarea::make('description')
                            ->rows(3)
                            ->placeholder('Short description for this product bag.')
                            ->columnSpanFull(),
                        Select::make('products')
                            ->label('Products in bag')
                            ->relationship('products', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Category Details')
                    ->description('Manage the category name, URL slug, visibility, and display order for the storefront.')
                    ->icon(Heroicon::Tag)
                    ->columns([
                        'default' => 1,
                        'md' => 3,
                    ])
                    ->components([
                        TextInput::make('name')
                            ->label('Category name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Women\'s Clothing')
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
                            ->placeholder('womens-clothing')
                            ->helperText('Use a short URL-friendly slug for filters and shop pages.')
                            ->unique(ignoreRecord: true),
                        TextInput::make('icon')
                            ->label('Icon')
                            ->maxLength(255)
                            ->placeholder('fas fa-male')
                            ->helperText('Use a Font Awesome class, for example: fas fa-male.'),
                        TextInput::make('sort_order')
                            ->label('Sort order')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        Toggle::make('is_active')
                            ->label('Active category')
                            ->helperText('Inactive categories can stay in admin without showing on the storefront.')
                            ->default(true)
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->rows(4)
                            ->placeholder('Short category description for merchandising and admin notes.')
                            ->columnSpanFull(),
                        FileUpload::make('image')
                            ->label('Category image')
                            ->image()
                            ->imageEditor()
                            ->directory('categories')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

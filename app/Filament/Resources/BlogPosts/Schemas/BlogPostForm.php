<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Blog content workspace')
                    ->description('Manage blog post content, media, and publishing settings from one place.')
                    ->icon(Heroicon::Newspaper)
                    ->components([
                        Tabs::make('Blog post tabs')
                            ->persistTabInQueryString('blog-post-tab')
                            ->tabs([
                                Tab::make('Content')
                                    ->icon(Heroicon::DocumentText)
                                    ->columns([
                                        'default' => 1,
                                        'md' => 2,
                                    ])
                                    ->components([
                                        TextInput::make('title')
                                            ->label('Post title')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('10 Must-Have Fashion Pieces for Winter 2024')
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (?string $state, ?string $old, Set $set, Get $get): void {
                                                $currentSlug = (string) $get('slug');
                                                $oldSlug = Str::slug((string) $old);

                                                if (blank($currentSlug) || ($currentSlug === $oldSlug)) {
                                                    $set('slug', Str::slug((string) $state));
                                                }
                                            })
                                            ->columnSpanFull(),
                                        TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('must-have-fashion-pieces-winter-2024')
                                            ->unique(ignoreRecord: true),
                                        TextInput::make('category')
                                            ->maxLength(255)
                                            ->placeholder('Fashion Trends'),
                                        TextInput::make('author_name')
                                            ->label('Author')
                                            ->required()
                                            ->maxLength(255)
                                            ->default('FashionHub Team')
                                            ->placeholder('Sarah Johnson'),
                                        Textarea::make('excerpt')
                                            ->rows(3)
                                            ->placeholder('Short summary for the blog listing page.')
                                            ->columnSpanFull(),
                                        Textarea::make('content')
                                            ->rows(16)
                                            ->required()
                                            ->placeholder('Write the full blog post content. Use line breaks to separate paragraphs.')
                                            ->helperText('Use one or more line breaks between paragraphs.')
                                            ->columnSpanFull(),
                                        FileUpload::make('featured_image')
                                            ->label('Featured image')
                                            ->image()
                                            ->imageEditor()
                                            ->directory('blog')
                                            ->disk('public')
                                            ->visibility('public')
                                            ->columnSpanFull(),
                                        TagsInput::make('tags')
                                            ->label('Tags')
                                            ->placeholder('Add tags')
                                            ->separator(',')
                                            ->splitKeys(['Tab', 'Enter', ','])
                                            ->columnSpanFull(),
                                    ]),
                                Tab::make('Publishing')
                                    ->icon(Heroicon::RocketLaunch)
                                    ->columns([
                                        'default' => 1,
                                        'md' => 2,
                                    ])
                                    ->components([
                                        DateTimePicker::make('publish_date')
                                            ->label('Publish date')
                                            ->seconds(false)
                                            ->native(false)
                                            ->helperText('Leave empty to publish immediately when active.'),
                                        Toggle::make('is_published')
                                            ->label('Published')
                                            ->default(true),
                                        TextInput::make('views_count')
                                            ->label('Views')
                                            ->numeric()
                                            ->default(0)
                                            ->minValue(0),
                                        TextInput::make('comments_count')
                                            ->label('Comments')
                                            ->numeric()
                                            ->default(0)
                                            ->minValue(0),
                                        TextInput::make('sort_order')
                                            ->label('Sort order')
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

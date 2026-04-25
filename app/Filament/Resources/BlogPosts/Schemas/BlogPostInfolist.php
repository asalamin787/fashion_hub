<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class BlogPostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Post overview')
                    ->icon(Heroicon::Newspaper)
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->components([
                        ImageEntry::make('featured_image')
                            ->label('Featured image')
                            ->disk('public')
                            ->columnSpanFull(),
                        TextEntry::make('title')
                            ->weight('bold')
                            ->columnSpanFull(),
                        TextEntry::make('slug')
                            ->badge(),
                        TextEntry::make('category')
                            ->placeholder('Uncategorized')
                            ->badge()
                            ->color('warning'),
                        TextEntry::make('author_name')
                            ->label('Author'),
                        TextEntry::make('publish_date')
                            ->label('Publish date')
                            ->dateTime('d M Y, h:i A')
                            ->placeholder('Publish immediately'),
                        TextEntry::make('excerpt')
                            ->placeholder('No excerpt provided')
                            ->columnSpanFull(),
                        TextEntry::make('content')
                            ->placeholder('No content')
                            ->columnSpanFull(),
                        TextEntry::make('tags')
                            ->formatStateUsing(fn (?array $state): string => implode(', ', $state ?? []))
                            ->placeholder('No tags')
                            ->columnSpanFull(),
                        TextEntry::make('views_count')
                            ->badge(),
                        TextEntry::make('comments_count')
                            ->badge(),
                        TextEntry::make('sort_order')
                            ->badge(),
                        IconEntry::make('is_published')
                            ->label('Published')
                            ->boolean(),
                        TextEntry::make('updated_at')
                            ->dateTime('d M Y, h:i A'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

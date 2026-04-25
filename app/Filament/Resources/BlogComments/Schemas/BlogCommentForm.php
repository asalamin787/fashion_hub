<?php

namespace App\Filament\Resources\BlogComments\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class BlogCommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Comment details')
                    ->icon(Heroicon::ChatBubbleBottomCenterText)
                    ->columns(2)
                    ->components([
                        Placeholder::make('post')
                            ->label('Blog post')
                            ->content(fn ($record): string => $record?->blogPost?->title ?? 'N/A')
                            ->columnSpanFull(),
                        TextInput::make('name')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(150),
                        TextInput::make('website')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('content')
                            ->label('Comment')
                            ->required()
                            ->rows(5)
                            ->maxLength(2000)
                            ->columnSpanFull(),
                        Toggle::make('is_approved')
                            ->label('Approved')
                            ->default(true),
                        Textarea::make('admin_reply')
                            ->label('Admin reply')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

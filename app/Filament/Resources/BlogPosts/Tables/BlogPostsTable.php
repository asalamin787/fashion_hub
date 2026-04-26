<?php

namespace App\Filament\Resources\BlogPosts\Tables;

use App\Models\BlogPost;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BlogPostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Image')
                    ->disk('public')
                    ->imageSize(48)
                    ->circular(),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->description(fn (BlogPost $record): string => $record->excerpt ? str((string) $record->excerpt)->limit(80)->toString() : 'No excerpt'),
                TextColumn::make('category')
                    ->badge()
                    ->color('warning')
                    ->placeholder('Uncategorized')
                    ->sortable(),
                TextColumn::make('author_name')
                    ->label('Author')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('publish_date')
                    ->label('Published at')
                    ->since()
                    ->sortable()
                    ->placeholder('Draft')
                    ->tooltip(fn (BlogPost $record): string => $record->publish_date?->format('d M Y, h:i A') ?? 'Not scheduled'),
                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->true(Heroicon::CheckCircle, 'success')
                    ->false(Heroicon::XCircle, 'danger')
                    ->sortable(),
                TextColumn::make('views_count')
                    ->label('Views')
                    ->badge()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray'),
                TextColumn::make('comments_count')
                    ->label('Comments')
                    ->badge()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('primary'),
                TextColumn::make('sort_order')
                    ->badge()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray'),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options(fn (): array => BlogPost::query()
                        ->whereNotNull('category')
                        ->where('category', '!=', '')
                        ->orderBy('category')
                        ->pluck('category', 'category')
                        ->all()),
                TernaryFilter::make('is_published')
                    ->label('Published status'),
            ])
            ->defaultSort('publish_date', 'desc')
            ->striped()
            ->defaultPaginationPageOption(10)
            ->paginationPageOptions([10, 25, 50])
            ->emptyStateIcon(Heroicon::Newspaper)
            ->emptyStateHeading('No blog posts found')
            ->emptyStateDescription('Create blog posts to publish content on the storefront blog page.')
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('publish')
                        ->label('Publish')
                        ->icon(Heroicon::CheckCircle)
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (BlogPost $record): bool => ! $record->is_published)
                        ->action(fn (BlogPost $record) => $record->update(['is_published' => true]))
                        ->successNotificationTitle('Blog post published.'),
                    Action::make('unpublish')
                        ->label('Unpublish')
                        ->icon(Heroicon::XCircle)
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn (BlogPost $record): bool => (bool) $record->is_published)
                        ->action(fn (BlogPost $record) => $record->update(['is_published' => false]))
                        ->successNotificationTitle('Blog post unpublished.'),
                    DeleteAction::make(),
                ])->label('Actions')
                    ->icon(Heroicon::EllipsisVertical)
                    ->button()
                    ->color('primary'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->searchPlaceholder('Search posts by title, author, or category');
    }
}

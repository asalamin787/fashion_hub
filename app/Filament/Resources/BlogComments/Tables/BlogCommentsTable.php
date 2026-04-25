<?php

namespace App\Filament\Resources\BlogComments\Tables;

use App\Models\BlogComment;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BlogCommentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('blogPost.title')
                    ->label('Post')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('content')
                    ->label('Comment')
                    ->limit(60)
                    ->tooltip(fn (BlogComment $record): string => (string) $record->content)
                    ->wrap(),
                IconColumn::make('is_approved')
                    ->label('Approved')
                    ->boolean()
                    ->sortable(),
                IconColumn::make('admin_reply')
                    ->label('Replied')
                    ->boolean(fn (BlogComment $record): bool => filled($record->admin_reply))
                    ->true(Heroicon::CheckCircle, 'success')
                    ->false(Heroicon::Clock, 'gray'),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->since()
                    ->sortable(),
                TextColumn::make('replied_at')
                    ->label('Replied at')
                    ->since()
                    ->placeholder('No reply')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_approved')
                    ->label('Approval status'),
                SelectFilter::make('blog_post_id')
                    ->label('Blog post')
                    ->relationship('blogPost', 'title')
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('has_reply')
                    ->label('Has reply')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('admin_reply')->where('admin_reply', '!=', ''),
                        false: fn ($query) => $query->where(function ($nestedQuery): void {
                            $nestedQuery
                                ->whereNull('admin_reply')
                                ->orWhere('admin_reply', '');
                        }),
                        blank: fn ($query) => $query,
                    ),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    Action::make('reply')
                        ->label('Reply')
                        ->icon(Heroicon::ArrowUturnLeft)
                        ->color('primary')
                        ->fillForm(fn (BlogComment $record): array => [
                            'admin_reply' => $record->admin_reply,
                        ])
                        ->form([
                            Textarea::make('admin_reply')
                                ->label('Reply message')
                                ->required()
                                ->rows(4)
                                ->maxLength(2000),
                        ])
                        ->action(function (BlogComment $record, array $data): void {
                            $record->update([
                                'admin_reply' => $data['admin_reply'],
                                'replied_at' => now(),
                                'is_approved' => true,
                            ]);
                        })
                        ->successNotificationTitle('Reply saved successfully.'),
                    Action::make('approve')
                        ->label('Approve')
                        ->icon(Heroicon::CheckCircle)
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (BlogComment $record): bool => ! $record->is_approved)
                        ->action(fn (BlogComment $record) => $record->update(['is_approved' => true]))
                        ->successNotificationTitle('Comment approved.'),
                    Action::make('unapprove')
                        ->label('Unapprove')
                        ->icon(Heroicon::XCircle)
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn (BlogComment $record): bool => (bool) $record->is_approved)
                        ->action(fn (BlogComment $record) => $record->update(['is_approved' => false]))
                        ->successNotificationTitle('Comment hidden from storefront.'),
                    DeleteAction::make(),
                ])->label('Actions')
                    ->button()
                    ->icon(Heroicon::EllipsisVertical)
                    ->color('primary'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->searchPlaceholder('Search by post title, commenter name, or email');
    }
}

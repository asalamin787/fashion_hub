<?php

namespace App\Filament\Resources\InstagramFeeds\Tables;

use App\Models\InstagramFeed;
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
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class InstagramFeedsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->imageSize(52)
                    ->circular(),
                TextColumn::make('section_title')
                    ->searchable()
                    ->sortable()
                    ->description(fn (InstagramFeed $record): string => $record->instagram_handle),
                TextColumn::make('sort_order')
                    ->badge()
                    ->sortable()
                    ->color('gray'),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->true(Heroicon::CheckCircle, 'success')
                    ->false(Heroicon::XCircle, 'danger')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->sortable()
                    ->tooltip(fn (InstagramFeed $record): string => $record->updated_at?->format('d M Y, h:i A') ?? '-'),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Active status'),
            ])
            ->defaultSort('sort_order')
            ->striped()
            ->defaultPaginationPageOption(10)
            ->paginationPageOptions([10, 25, 50])
            ->emptyStateIcon(Heroicon::Photo)
            ->emptyStateHeading('No instagram feeds found')
            ->emptyStateDescription('Create instagram posts to show in the homepage marquee section.')
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('activate')
                        ->label('Activate')
                        ->icon(Heroicon::CheckCircle)
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (InstagramFeed $record): bool => ! $record->is_active)
                        ->action(fn (InstagramFeed $record) => $record->update(['is_active' => true]))
                        ->successNotificationTitle('Instagram post activated.'),
                    Action::make('deactivate')
                        ->label('Deactivate')
                        ->icon(Heroicon::XCircle)
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn (InstagramFeed $record): bool => (bool) $record->is_active)
                        ->action(fn (InstagramFeed $record) => $record->update(['is_active' => false]))
                        ->successNotificationTitle('Instagram post deactivated.'),
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
            ->searchPlaceholder('Search by title or handle');
    }
}

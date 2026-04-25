<?php

namespace App\Filament\Resources\Offers\Tables;

use App\Models\Offer;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OffersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Offer $record): string => $record->code ?? 'No coupon code'),
                TextColumn::make('type')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => $state === 'percentage' ? 'info' : 'success')
                    ->formatStateUsing(fn (string $state): string => $state === 'percentage' ? 'Percentage' : 'Fixed'),
                TextColumn::make('formatted_value')
                    ->label('Value')
                    ->badge()
                    ->color('warning'),
                TextColumn::make('products_count')
                    ->label('Products')
                    ->counts('products')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->true(Heroicon::CheckCircle, 'success')
                    ->false(Heroicon::XCircle, 'danger')
                    ->sortable(),
                TextColumn::make('starts_at')
                    ->label('Starts')
                    ->dateTime('d M Y')
                    ->placeholder('Immediately')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime('d M Y')
                    ->placeholder('No expiry')
                    ->sortable()
                    ->color(fn (Offer $record): string => $record->expires_at?->isPast() ? 'danger' : 'success'),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->sortable()
                    ->tooltip(fn (Offer $record): string => $record->updated_at?->format('d M Y, h:i A') ?? '-'),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'percentage' => 'Percentage',
                        'fixed' => 'Fixed amount',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Active status'),
                TernaryFilter::make('has_expiry')
                    ->label('Has expiry')
                    ->placeholder('All offers')
                    ->trueLabel('With expiry')
                    ->falseLabel('Without expiry')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->whereNotNull('expires_at'),
                        false: fn (Builder $query): Builder => $query->whereNull('expires_at'),
                        blank: fn (Builder $query): Builder => $query,
                    ),
                TernaryFilter::make('expired')
                    ->label('Expiry state')
                    ->placeholder('All')
                    ->trueLabel('Expired')
                    ->falseLabel('Valid')
                    ->queries(
                        true: fn (Builder $query): Builder => $query->where('expires_at', '<', now()),
                        false: fn (Builder $query): Builder => $query->where(fn (Builder $q): Builder => $q->whereNull('expires_at')->orWhere('expires_at', '>=', now())),
                        blank: fn (Builder $query): Builder => $query,
                    ),
            ])
            ->defaultSort('updated_at', 'desc')
            ->striped()
            ->defaultPaginationPageOption(10)
            ->paginationPageOptions([10, 25, 50])
            ->emptyStateIcon(Heroicon::Tag)
            ->emptyStateHeading('No offers found')
            ->emptyStateDescription('Create an offer to apply discounts to products in your catalog.')
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('activate')
                        ->label('Activate')
                        ->icon(Heroicon::CheckCircle)
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (Offer $record): bool => ! $record->is_active)
                        ->action(fn (Offer $record) => $record->update(['is_active' => true]))
                        ->successNotificationTitle('Offer activated.'),
                    Action::make('deactivate')
                        ->label('Deactivate')
                        ->icon(Heroicon::XCircle)
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn (Offer $record): bool => (bool) $record->is_active)
                        ->action(fn (Offer $record) => $record->update(['is_active' => false]))
                        ->successNotificationTitle('Offer deactivated.'),
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
            ->searchPlaceholder('Search offers by title or code');
    }
}

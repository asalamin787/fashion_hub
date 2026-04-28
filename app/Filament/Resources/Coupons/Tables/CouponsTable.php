<?php

namespace App\Filament\Resources\Coupons\Tables;

use App\Models\Coupon;
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

class CouponsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Coupon $record): string => $record->code),
                TextColumn::make('type')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => $state === 'percentage' ? 'info' : 'success')
                    ->formatStateUsing(fn (string $state): string => $state === 'percentage' ? 'Percentage' : 'Fixed'),
                TextColumn::make('formatted_value')
                    ->label('Value')
                    ->badge()
                    ->color('warning'),
                TextColumn::make('min_order_amount')
                    ->label('Min order')
                    ->formatStateUsing(fn (?string $state): string => $state !== null ? '$'.number_format((float) $state, 2) : '-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('usage_limit')
                    ->label('Usage')
                    ->formatStateUsing(fn (Coupon $record): string => $record->usage_limit ? "{$record->used_count} / {$record->usage_limit}" : (string) $record->used_count)
                    ->badge()
                    ->color('gray'),
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
                    ->color(fn (Coupon $record): string => $record->expires_at?->isPast() ? 'danger' : 'success'),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'percentage' => 'Percentage',
                        'fixed' => 'Fixed amount',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Active status'),
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
            ->emptyStateHeading('No coupons found')
            ->emptyStateDescription('Create a coupon to manage dynamic discounts from the admin panel.')
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('activate')
                        ->label('Activate')
                        ->icon(Heroicon::CheckCircle)
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (Coupon $record): bool => ! $record->is_active)
                        ->action(fn (Coupon $record) => $record->update(['is_active' => true]))
                        ->successNotificationTitle('Coupon activated.'),
                    Action::make('deactivate')
                        ->label('Deactivate')
                        ->icon(Heroicon::XCircle)
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn (Coupon $record): bool => (bool) $record->is_active)
                        ->action(fn (Coupon $record) => $record->update(['is_active' => false]))
                        ->successNotificationTitle('Coupon deactivated.'),
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
            ->searchPlaceholder('Search coupons by name or code');
    }
}

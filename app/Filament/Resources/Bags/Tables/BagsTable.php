<?php

namespace App\Filament\Resources\Bags\Tables;

use App\Models\Bag;
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
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BagsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->rowIndex()
                    ->alignCenter(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->icon(Heroicon::ShoppingCart)
                    ->iconColor('info'),
                TextColumn::make('slug')
                    ->searchable()
                    ->copyable()
                    ->badge()
                    ->color('gray'),
                TextColumn::make('products_count')
                    ->label('Products')
                    ->counts('products')
                    ->badge()
                    ->color('info')
                    ->sortable(),
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
                    ->tooltip(fn (Bag $record): string => $record->updated_at?->format('d M Y, h:i A') ?? '-'),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Active status'),
            ])
            ->defaultSort('updated_at', 'desc')
            ->striped()
            ->defaultPaginationPageOption(10)
            ->paginationPageOptions([10, 25, 50])
            ->emptyStateIcon(Heroicon::ShoppingCart)
            ->emptyStateHeading('No bags found')
            ->emptyStateDescription('Create a bag to group related products into curated collections.')
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('activate')
                        ->label('Activate')
                        ->icon(Heroicon::CheckCircle)
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (Bag $record): bool => ! $record->is_active)
                        ->action(fn (Bag $record) => $record->update(['is_active' => true]))
                        ->successNotificationTitle('Bag activated.'),
                    Action::make('deactivate')
                        ->label('Deactivate')
                        ->icon(Heroicon::XCircle)
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn (Bag $record): bool => (bool) $record->is_active)
                        ->action(fn (Bag $record) => $record->update(['is_active' => false]))
                        ->successNotificationTitle('Bag deactivated.'),
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
            ->searchPlaceholder('Search bags by name');
    }
}

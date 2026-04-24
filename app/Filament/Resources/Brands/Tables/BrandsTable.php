<?php

namespace App\Filament\Resources\Brands\Tables;

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
use Illuminate\Database\Eloquent\Builder;

class BrandsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->rowIndex()
                    ->alignCenter(),
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->disk('public')
                    ->circular()
                    ->imageSize(40)
                    ->defaultImageUrl(asset('assets/images/category-placeholder.svg')),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->icon(Heroicon::Tag)
                    ->iconColor('warning'),
                TextColumn::make('slug')
                    ->searchable()
                    ->copyable()
                    ->badge()
                    ->color('gray'),
                TextColumn::make('website')
                    ->url(fn ($state) => $state)
                    ->openUrlInNewTab()
                    ->placeholder('No website')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->true(Heroicon::CheckCircle, 'success')
                    ->false(Heroicon::XCircle, 'danger')
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->badge()
                    ->sortable()
                    ->color('warning'),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->since()
                    ->sortable()
                    ->tooltip(fn ($record): string => $record->created_at?->format('d M Y, h:i A') ?? '-'),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Active status'),
                TernaryFilter::make('has_logo')
                    ->label('Has logo')
                    ->placeholder('All brands')
                    ->trueLabel('With logo')
                    ->falseLabel('Without logo')
                    ->queries(
                        true: fn (Builder $query): Builder => $query
                            ->whereNotNull('logo')
                            ->where('logo', '!=', ''),
                        false: fn (Builder $query): Builder => $query
                            ->where(function (Builder $query): void {
                                $query
                                    ->whereNull('logo')
                                    ->orWhere('logo', '');
                            }),
                        blank: fn (Builder $query): Builder => $query,
                    ),
            ])
            ->defaultSort('sort_order')
            ->striped()
            ->defaultPaginationPageOption(10)
            ->paginationPageOptions([10, 25, 50])
            ->emptyStateIcon(Heroicon::Tag)
            ->emptyStateHeading('No brands found')
            ->emptyStateDescription('Create a brand to organize products and storefront filters.')
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label('View brand')
                        ->icon(Heroicon::Eye)
                        ->color('gray'),
                    EditAction::make()
                        ->label('Edit brand')
                        ->icon(Heroicon::PencilSquare),
                    Action::make('activate')
                        ->label('Activate brand')
                        ->icon(Heroicon::CheckCircle)
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn ($record): bool => ! $record->is_active)
                        ->action(fn ($record) => $record->update(['is_active' => true]))
                        ->successNotificationTitle('Brand activated successfully.'),
                    Action::make('deactivate')
                        ->label('Deactivate brand')
                        ->icon(Heroicon::XCircle)
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn ($record): bool => (bool) $record->is_active)
                        ->action(fn ($record) => $record->update(['is_active' => false]))
                        ->successNotificationTitle('Brand deactivated successfully.'),
                    DeleteAction::make()
                        ->label('Delete brand')
                        ->icon(Heroicon::Trash)
                        ->color('danger'),
                ])
                    ->label('Actions')
                    ->icon(Heroicon::EllipsisVertical)
                    ->button()
                    ->color('primary'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->searchPlaceholder('Search brands by name or slug');
    }
}

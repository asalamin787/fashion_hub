<?php

namespace App\Filament\Resources\Categories\Tables;

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
use Illuminate\Database\Eloquent\Builder;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->rowIndex()
                    ->alignCenter(),
                ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->circular()
                    ->imageSize(42)
                    ->defaultImageUrl(asset('assets/images/category-placeholder.svg')),
                IconColumn::make('icon')
                    ->label('Icon')
                    ->icon(fn (?string $state): Heroicon => match ($state) {
                        'heroicon-o-tag' => Heroicon::Tag,
                        'heroicon-o-squares-2x2' => Heroicon::Squares2x2,
                        'heroicon-o-shirt' => Heroicon::ShoppingBag,
                        default => Heroicon::Tag,
                    })
                    ->color('warning')
                    ->tooltip(fn (?string $state): string => $state ?: 'heroicon-o-tag'),
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
                TextColumn::make('description')
                    ->limit(50)
                    ->placeholder('No description')
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
                SelectFilter::make('icon')
                    ->label('Category icon')
                    ->options([
                        'heroicon-o-tag' => 'Tag icon',
                        'heroicon-o-squares-2x2' => 'Squares icon',
                        'heroicon-o-shirt' => 'Shirt icon',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Active status'),
                TernaryFilter::make('has_image')
                    ->label('Has image')
                    ->placeholder('All categories')
                    ->trueLabel('With image')
                    ->falseLabel('Without image')
                    ->queries(
                        true: fn (Builder $query): Builder => $query
                            ->whereNotNull('image')
                            ->where('image', '!=', ''),
                        false: fn (Builder $query): Builder => $query
                            ->where(function (Builder $query): void {
                                $query
                                    ->whereNull('image')
                                    ->orWhere('image', '');
                            }),
                        blank: fn (Builder $query): Builder => $query,
                    ),
            ])
            ->defaultSort('sort_order')
            ->striped()
            ->defaultPaginationPageOption(10)
            ->paginationPageOptions([10, 25, 50])
            ->emptyStateIcon(Heroicon::Tag)
            ->emptyStateHeading('No categories found')
            ->emptyStateDescription('Create a category to organize products across the storefront and admin.')
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label('View category')
                        ->icon(Heroicon::Eye)
                        ->color('gray'),
                    EditAction::make()
                        ->label('Edit category')
                        ->icon(Heroicon::PencilSquare),
                    Action::make('activate')
                        ->label('Activate category')
                        ->icon(Heroicon::CheckCircle)
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn ($record): bool => ! $record->is_active)
                        ->action(fn ($record) => $record->update(['is_active' => true]))
                        ->successNotificationTitle('Category activated successfully.'),
                    Action::make('deactivate')
                        ->label('Deactivate category')
                        ->icon(Heroicon::XCircle)
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn ($record): bool => (bool) $record->is_active)
                        ->action(fn ($record) => $record->update(['is_active' => false]))
                        ->successNotificationTitle('Category deactivated successfully.'),
                    DeleteAction::make()
                        ->label('Delete category')
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
            ->searchPlaceholder('Search categories by name or slug');
    }
}

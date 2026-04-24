<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Product;
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

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Image')
                    ->disk('public')
                    ->imageSize(52)
                    ->circular(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Product $record): string => $record->slug),
                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'warning',
                    }),
                IconColumn::make('has_variants')
                    ->label('Variants')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('price_range_display')
                    ->label('Price range')
                    ->state(function (Product $record): string {
                        $range = $record->price_range;

                        if (! is_array($range)) {
                            return 'Not set';
                        }

                        $min = number_format((float) $range['min'], 2);
                        $max = number_format((float) $range['max'], 2);

                        return $min === $max ? $min : $min.' - '.$max;
                    })
                    ->badge()
                    ->color('gray'),
                TextColumn::make('stock_summary')
                    ->label('Stock summary')
                    ->state(function (Product $record): string {
                        if (! $record->has_variants) {
                            return (string) $record->stock;
                        }

                        $totalStock = collect($record->variants ?? [])
                            ->filter(fn (mixed $variant): bool => is_array($variant))
                            ->sum(fn (array $variant): int => (int) ($variant['stock'] ?? 0));

                        return $totalStock.' across '.count($record->variants ?? []).' variants';
                    })
                    ->badge()
                    ->color(function (Product $record): string {
                        $stock = $record->has_variants
                            ? collect($record->variants ?? [])->sum(fn (array $variant): int => (int) ($variant['stock'] ?? 0))
                            : (int) $record->stock;

                        return $stock > 0 ? 'success' : 'danger';
                    }),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->sortable()
                    ->tooltip(fn (Product $record): string => $record->updated_at?->format('d M Y, h:i A') ?? '-'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('has_variants')
                    ->label('Variant type'),
                TernaryFilter::make('has_featured_image')
                    ->label('Has featured image')
                    ->placeholder('All products')
                    ->trueLabel('With image')
                    ->falseLabel('Without image')
                    ->queries(
                        true: fn (Builder $query): Builder => $query
                            ->whereNotNull('featured_image')
                            ->where('featured_image', '!=', ''),
                        false: fn (Builder $query): Builder => $query
                            ->where(function (Builder $query): void {
                                $query
                                    ->whereNull('featured_image')
                                    ->orWhere('featured_image', '');
                            }),
                        blank: fn (Builder $query): Builder => $query,
                    ),
            ])
            ->defaultSort('updated_at', 'desc')
            ->striped()
            ->defaultPaginationPageOption(10)
            ->paginationPageOptions([10, 25, 50])
            ->emptyStateHeading('No products found')
            ->emptyStateDescription('Create your first product and manage simple or multi-variation inventory from one JSON-powered record.')
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('setActive')
                        ->label('Set active')
                        ->icon(Heroicon::CheckCircle)
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn ($record): bool => $record->status !== 'active')
                        ->action(fn ($record) => $record->update(['status' => 'active']))
                        ->successNotificationTitle('Product set to active.'),
                    Action::make('setInactive')
                        ->label('Set inactive')
                        ->icon(Heroicon::XCircle)
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn ($record): bool => $record->status !== 'inactive')
                        ->action(fn ($record) => $record->update(['status' => 'inactive']))
                        ->successNotificationTitle('Product set to inactive.'),
                    Action::make('setDraft')
                        ->label('Set draft')
                        ->icon(Heroicon::DocumentText)
                        ->color('gray')
                        ->requiresConfirmation()
                        ->visible(fn ($record): bool => $record->status !== 'draft')
                        ->action(fn ($record) => $record->update(['status' => 'draft']))
                        ->successNotificationTitle('Product set to draft.'),
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
            ->searchPlaceholder('Search products by name');
    }
}

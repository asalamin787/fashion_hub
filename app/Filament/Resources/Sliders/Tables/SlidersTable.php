<?php

namespace App\Filament\Resources\Sliders\Tables;

use App\Models\Slider;
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

class SlidersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('background_image')
                    ->label('Image')
                    ->disk('public')
                    ->imageSize(56)
                    ->circular(),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Slider $record): string => $record->subtitle ?? '-'),
                TextColumn::make('primary_button_text')
                    ->label('Primary CTA')
                    ->badge()
                    ->placeholder('No button')
                    ->color('warning'),
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
                    ->tooltip(fn (Slider $record): string => $record->updated_at?->format('d M Y, h:i A') ?? '-'),
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
            ->emptyStateHeading('No sliders found')
            ->emptyStateDescription('Create sliders to control homepage hero content from the admin panel.')
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('activate')
                        ->label('Activate')
                        ->icon(Heroicon::CheckCircle)
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (Slider $record): bool => ! $record->is_active)
                        ->action(fn (Slider $record) => $record->update(['is_active' => true]))
                        ->successNotificationTitle('Slider activated.'),
                    Action::make('deactivate')
                        ->label('Deactivate')
                        ->icon(Heroicon::XCircle)
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn (Slider $record): bool => (bool) $record->is_active)
                        ->action(fn (Slider $record) => $record->update(['is_active' => false]))
                        ->successNotificationTitle('Slider deactivated.'),
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
            ->searchPlaceholder('Search sliders by title');
    }
}

<?php

namespace App\Filament\Resources\AboutPages\Tables;

use App\Models\AboutPage;
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

class AboutPagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hero_title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('hero_subtitle')
                    ->limit(50)
                    ->toggleable(),
                TextColumn::make('sort_order')
                    ->badge()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->true(Heroicon::CheckCircle, 'success')
                    ->false(Heroicon::XCircle, 'danger')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_active'),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('activate')
                        ->label('Activate')
                        ->icon(Heroicon::CheckCircle)
                        ->color('success')
                        ->visible(fn (AboutPage $record): bool => ! $record->is_active)
                        ->action(fn (AboutPage $record) => $record->update(['is_active' => true])),
                    Action::make('deactivate')
                        ->label('Deactivate')
                        ->icon(Heroicon::XCircle)
                        ->color('warning')
                        ->visible(fn (AboutPage $record): bool => (bool) $record->is_active)
                        ->action(fn (AboutPage $record) => $record->update(['is_active' => false])),
                    DeleteAction::make(),
                ])->button()->color('primary'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

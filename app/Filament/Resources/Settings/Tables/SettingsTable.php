<?php

namespace App\Filament\Resources\Settings\Tables;

use App\Models\Setting;
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

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group')
                    ->badge()
                    ->sortable()
                    ->color('info'),
                TextColumn::make('key')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->description(fn (Setting $record): string => $record->label),
                TextColumn::make('type')
                    ->badge()
                    ->sortable()
                    ->color('warning'),
                TextColumn::make('formatted_value')
                    ->label('Value')
                    ->wrap()
                    ->limit(80),
                IconColumn::make('is_public')
                    ->label('Public')
                    ->boolean()
                    ->true(Heroicon::CheckCircle, 'success')
                    ->false(Heroicon::XCircle, 'gray')
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->options(array_combine(Setting::GROUPS, array_map(static fn (string $group): string => ucfirst($group), Setting::GROUPS))),
                SelectFilter::make('type')
                    ->options(array_combine(Setting::TYPES, array_map(static fn (string $type): string => ucfirst($type), Setting::TYPES))),
                TernaryFilter::make('is_public')
                    ->label('Public visibility'),
            ])
            ->defaultSort('group')
            ->striped()
            ->defaultPaginationPageOption(25)
            ->paginationPageOptions([25, 50, 100])
            ->emptyStateIcon(Heroicon::Cog6Tooth)
            ->emptyStateHeading('No settings available')
            ->emptyStateDescription('Create a setting to manage your system configuration from one place.')
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->searchPlaceholder('Search settings by key or label');
    }
}

<?php

namespace App\Filament\Resources\Users\Tables;

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

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->rowIndex()
                    ->alignCenter(),
                ImageColumn::make('avatar')
                    ->label('Photo')
                    ->state(fn ($record): ?string => filled($record->avatar)
                        ? (filter_var((string) $record->avatar, FILTER_VALIDATE_URL)
                            ? (string) $record->avatar
                            : asset('storage/'.ltrim((string) $record->avatar, '/')))
                        : null)
                    ->defaultImageUrl(fn ($record): string => 'https://ui-avatars.com/api/?name='.urlencode($record->name).'&background=111827&color=ffffff')
                    ->circular()
                    ->imageSize(44),
                TextColumn::make('name')
                    ->description(fn ($record): string => $record->email)
                    ->searchable()
                    ->sortable()
                    ->icon(Heroicon::User)
                    ->iconColor('gray'),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('role')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => str($state)->headline()->toString())
                    ->icon(fn (string $state): Heroicon => $state === 'admin' ? Heroicon::ShieldCheck : Heroicon::User)
                    ->color(fn (string $state): string => $state === 'admin' ? 'danger' : 'info')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->true(Heroicon::CheckCircle, 'success')
                    ->false(Heroicon::XCircle, 'danger')
                    ->label('Active')
                    ->sortable(),
                TextColumn::make('date_of_birth')
                    ->date('d M Y')
                    ->placeholder('Not set')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('phone')
                    ->searchable()
                    ->placeholder('No phone')
                    ->icon(Heroicon::Phone)
                    ->iconColor('gray')
                    ->toggleable(),
                TextColumn::make('location')
                    ->state(fn ($record): ?string => collect([$record->city, $record->country])->filter()->join(', '))
                    ->placeholder('No location')
                    ->icon(Heroicon::MapPin)
                    ->iconColor('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->label('Joined')
                    ->tooltip(fn ($record): string => $record->created_at?->format('d M Y, h:i A') ?? '-')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'Normal user',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Active status'),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->defaultPaginationPageOption(10)
            ->paginationPageOptions([10, 25, 50])
            ->emptyStateIcon(Heroicon::Users)
            ->emptyStateHeading('No users found')
            ->emptyStateDescription('Create a new user to start building your team.')
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label('View profile')
                        ->icon(Heroicon::Eye)
                        ->color('gray'),
                    EditAction::make()
                        ->label('Edit user')
                        ->icon(Heroicon::PencilSquare),
                    Action::make('activate')
                        ->label('Activate user')
                        ->icon(Heroicon::CheckCircle)
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn ($record): bool => ! $record->is_active)
                        ->action(fn ($record) => $record->update(['is_active' => true]))
                        ->successNotificationTitle('User activated successfully.'),
                    Action::make('deactivate')
                        ->label('Deactivate user')
                        ->icon(Heroicon::XCircle)
                        ->color('warning')
                        ->requiresConfirmation()
                        ->visible(fn ($record): bool => (bool) $record->is_active)
                        ->action(fn ($record) => $record->update(['is_active' => false]))
                        ->successNotificationTitle('User deactivated successfully.'),
                    DeleteAction::make()
                        ->label('Delete user')
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
            ->searchPlaceholder('Search users by name, email, or phone');
    }
}

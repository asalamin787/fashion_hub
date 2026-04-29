<?php

namespace App\Filament\Resources\Settings\Pages;

use App\Filament\Pages\SettingsManager;
use App\Filament\Resources\Settings\SettingResource;
use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('openManager')
                ->label('Open Settings Manager')
                ->icon(Heroicon::Cog6Tooth)
                ->color('primary')
                ->url(SettingsManager::getUrl()),
            Action::make('clearCache')
                ->label('Clear Settings Cache')
                ->icon(Heroicon::ArrowPath)
                ->color('gray')
                ->action(function (): void {
                    Setting::forgetCache();
                })
                ->successNotificationTitle('Settings cache cleared.'),
            CreateAction::make(),
        ];
    }
}

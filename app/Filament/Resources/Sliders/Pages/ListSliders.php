<?php

namespace App\Filament\Resources\Sliders\Pages;

use App\Filament\Resources\Sliders\SliderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSliders extends ListRecords
{
    protected static string $resource = SliderResource::class;

    protected static ?string $title = 'Homepage Sliders';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create slider'),
        ];
    }
}

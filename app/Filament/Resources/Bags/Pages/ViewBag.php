<?php

namespace App\Filament\Resources\Bags\Pages;

use App\Filament\Resources\Bags\BagResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBag extends ViewRecord
{
    protected static string $resource = BagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}

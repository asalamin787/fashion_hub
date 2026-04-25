<?php

namespace App\Filament\Resources\Bags\Pages;

use App\Filament\Resources\Bags\BagResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBag extends EditRecord
{
    protected static string $resource = BagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

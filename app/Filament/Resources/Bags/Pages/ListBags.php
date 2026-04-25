<?php

namespace App\Filament\Resources\Bags\Pages;

use App\Filament\Resources\Bags\BagResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBags extends ListRecords
{
    protected static string $resource = BagResource::class;

    protected static ?string $title = 'Product Bags';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create bag'),
        ];
    }
}

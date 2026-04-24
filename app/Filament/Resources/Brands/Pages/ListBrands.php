<?php

namespace App\Filament\Resources\Brands\Pages;

use App\Filament\Resources\Brands\BrandResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

    protected static ?string $title = 'Brand Directory';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add new brand'),
        ];
    }
}

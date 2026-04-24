<?php

namespace App\Filament\Resources\Brands\Pages;

use App\Filament\Resources\Brands\BrandResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBrand extends ViewRecord
{
    protected static string $resource = BrandResource::class;

    protected static ?string $title = 'Brand Details';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

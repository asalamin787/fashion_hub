<?php

namespace App\Filament\Resources\Offers\Pages;

use App\Filament\Resources\Offers\OfferResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOffers extends ListRecords
{
    protected static string $resource = OfferResource::class;

    protected static ?string $title = 'Product Offers';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create offer'),
        ];
    }
}

<?php

namespace App\Filament\Resources\Bags\Pages;

use App\Filament\Resources\Bags\BagResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBag extends CreateRecord
{
    protected static string $resource = BagResource::class;

    protected static ?string $title = 'Create Bag';
}

<?php

namespace App\Filament\Resources\Bags;

use App\Filament\Resources\Bags\Pages\CreateBag;
use App\Filament\Resources\Bags\Pages\EditBag;
use App\Filament\Resources\Bags\Pages\ListBags;
use App\Filament\Resources\Bags\Pages\ViewBag;
use App\Filament\Resources\Bags\Schemas\BagForm;
use App\Filament\Resources\Bags\Schemas\BagInfolist;
use App\Filament\Resources\Bags\Tables\BagsTable;
use App\Models\Bag;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BagResource extends Resource
{
    protected static ?string $model = Bag::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;

    protected static ?string $navigationLabel = 'Bags';

    protected static ?string $modelLabel = 'Bag';

    protected static ?string $pluralModelLabel = 'Product Bags';

    protected static string|UnitEnum|null $navigationGroup = 'Catalog Management';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BagForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BagInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BagsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBags::route('/'),
            'create' => CreateBag::route('/create'),
            'view' => ViewBag::route('/{record}'),
            'edit' => EditBag::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }
}

<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages\InvoiceOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Pages\ViewOrder;
use App\Filament\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use UnitEnum;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;

    protected static ?string $navigationLabel = 'Orders';

    protected static ?string $modelLabel = 'Order';

    protected static ?string $pluralModelLabel = 'Orders';

    protected static string|UnitEnum|null $navigationGroup = 'Order Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'order_number';

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['items', 'user', 'payments']);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'view' => ViewOrder::route('/{record}'),
            'invoice' => InvoiceOrder::route('/{record}/invoice'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getViewItemsModalUrl(int|string|Model $record): string
    {
        $recordKey = $record instanceof Model ? $record->getKey() : $record;

        $paginationPage = request()->query('page');

        if (blank($paginationPage)) {
            $previousUrlQuery = parse_url(url()->previous(), PHP_URL_QUERY);

            if (is_string($previousUrlQuery) && filled($previousUrlQuery)) {
                parse_str($previousUrlQuery, $previousQuery);
                $paginationPage = Arr::get($previousQuery, 'page');
            }
        }

        $parameters = [
            'tableAction' => 'viewItems',
            'tableActionRecord' => $recordKey,
        ];

        if (filled($paginationPage)) {
            $parameters['page'] = $paginationPage;
        }

        return static::getUrl('index', $parameters);
    }
}

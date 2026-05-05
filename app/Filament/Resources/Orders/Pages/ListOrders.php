<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Enums\OrderStatus;
use App\Filament\Resources\Orders\OrderResource;
use App\Filament\Resources\Orders\Widgets\OrdersOverview;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected static ?string $title = 'Orders';

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrdersOverview::class,
        ];
    }

    public function getWidgetData(): array
    {
        $data = parent::getWidgetData();

        $data['tableColumnSearches'] = is_array($data['tableColumnSearches'] ?? null)
            ? $data['tableColumnSearches']
            : [];

        $data['paginators'] = is_array($data['paginators'] ?? null)
            ? $data['paginators']
            : [];

        return $data;
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'new' => Tab::make('New')
                ->badge($this->getStatusCount(OrderStatus::Pending))
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('order_status', OrderStatus::Pending->value)),
            'processing' => Tab::make('Processing')
                ->badge($this->getStatusCount(OrderStatus::Processing))
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('order_status', OrderStatus::Processing->value)),
            'shipped' => Tab::make('Shipped')
                ->badge($this->getStatusCount(OrderStatus::Shipped))
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('order_status', OrderStatus::Shipped->value)),
            'delivered' => Tab::make('Delivered')
                ->badge($this->getStatusCount(OrderStatus::Delivered))
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('order_status', OrderStatus::Delivered->value)),
            'cancelled' => Tab::make('Cancelled')
                ->badge($this->getStatusCount(OrderStatus::Cancelled))
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('order_status', OrderStatus::Cancelled->value)),
        ];
    }

    private function getStatusCount(OrderStatus $status): int
    {
        return OrderResource::getModel()::query()
            ->where('order_status', $status->value)
            ->count();
    }
}

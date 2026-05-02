<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class OrdersTable
{
    private static function viewItemsAction(): Action
    {
        return Action::make('viewItems')
            ->label('View Order Items')
            ->icon('heroicon-o-shopping-bag')
            ->color('info')
            ->modalHeading(fn (Order $record): string => "Order Items — {$record->order_number}")
            ->modalContent(fn (Order $record) => view('filament.orders.components.expanded-order-details', ['order' => $record->load('items')]))
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Close')
            ->modalWidth(Width::FiveExtraLarge);
    }

    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->recordClasses(fn (): string => 'fi-ta-record-actions-top')
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->size(TextSize::Medium)
                    ->color('primary')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->action(self::viewItemsAction()),

                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->state(fn (?Order $record): string => $record ? trim("{$record->customer_first_name} {$record->customer_last_name}") : 'Guest')
                    ->searchable(['customer_first_name', 'customer_last_name'])
                    ->weight(FontWeight::SemiBold)
                    ->icon(Heroicon::OutlinedUser),

                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('USD')
                    ->sortable()
                    ->alignCenter()
                    ->color('primary')
                    ->action(self::viewItemsAction()),

                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('USD')
                    ->sortable()
                    ->color('primary')
                    ->action(self::viewItemsAction()),

                TextColumn::make('payment_status')
                    ->label('Payment Status')
                    ->badge()
                    ->formatStateUsing(fn (PaymentStatus $state): string => $state->name)
                    ->color(fn (PaymentStatus $state): string => match ($state) {
                        PaymentStatus::Paid => 'success',
                        PaymentStatus::Authorized => 'info',
                        PaymentStatus::Failed, PaymentStatus::Cancelled => 'danger',
                        PaymentStatus::Refunded, PaymentStatus::PartiallyRefunded => 'purple',
                        default => 'warning',
                    }),

                TextColumn::make('payment_method')
                    ->label('Method')
                    ->badge()
                    ->formatStateUsing(fn (PaymentMethod $state): string => match ($state) {
                        PaymentMethod::CreditCard => 'Credit Card',
                        PaymentMethod::Paypal => 'PayPal',
                        PaymentMethod::CashOnDelivery => 'Cash on Delivery',
                    })
                    ->color(fn (PaymentMethod $state): string => match ($state) {
                        PaymentMethod::CreditCard => 'primary',
                        PaymentMethod::Paypal => 'info',
                        PaymentMethod::CashOnDelivery => 'warning',
                    })
                    ->icon(fn (PaymentMethod $state): string => match ($state) {
                        PaymentMethod::CreditCard => 'heroicon-o-credit-card',
                        PaymentMethod::Paypal => 'heroicon-o-globe-alt',
                        PaymentMethod::CashOnDelivery => 'heroicon-o-banknotes',
                    }),

                TextColumn::make('order_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (OrderStatus $state): string => $state->name)
                    ->color(fn (OrderStatus $state): string => match ($state) {
                        OrderStatus::Pending => 'warning',
                        OrderStatus::Confirmed => 'info',
                        OrderStatus::Processing => 'primary',
                        OrderStatus::Shipped => 'purple',
                        OrderStatus::Delivered => 'success',
                        OrderStatus::Cancelled => 'danger',
                        OrderStatus::Refunded => 'gray',
                    })
                    ->icon(fn (OrderStatus $state): string => match ($state) {
                        OrderStatus::Pending => 'heroicon-o-clock',
                        OrderStatus::Confirmed => 'heroicon-o-check',
                        OrderStatus::Processing => 'heroicon-o-cog-6-tooth',
                        OrderStatus::Shipped => 'heroicon-o-truck',
                        OrderStatus::Delivered => 'heroicon-o-check-circle',
                        OrderStatus::Cancelled => 'heroicon-o-x-circle',
                        OrderStatus::Refunded => 'heroicon-o-arrow-uturn-left',
                    }),
            ])
            ->filters([
                SelectFilter::make('order_status')
                    ->label('Order Status')
                    ->options(
                        collect(OrderStatus::cases())
                            ->mapWithKeys(fn (OrderStatus $s): array => [$s->value => $s->name])
                            ->toArray()
                    )
                    ->attribute('order_status'),

                SelectFilter::make('payment_status')
                    ->label('Payment Status')
                    ->options(
                        collect(PaymentStatus::cases())
                            ->mapWithKeys(fn (PaymentStatus $s): array => [$s->value => $s->name])
                            ->toArray()
                    )
                    ->attribute('payment_status'),

                SelectFilter::make('payment_method')
                    ->label('Payment Method')
                    ->options(
                        collect(PaymentMethod::cases())
                            ->mapWithKeys(fn (PaymentMethod $m): array => [$m->value => match ($m) {
                                PaymentMethod::CreditCard => 'Credit Card',
                                PaymentMethod::Paypal => 'PayPal',
                                PaymentMethod::CashOnDelivery => 'Cash on Delivery',
                            }])
                            ->toArray()
                    )
                    ->attribute('payment_method'),

                Filter::make('date_range')
                    ->label('Date Range')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('From')
                            ->native(false)
                            ->displayFormat('d M Y'),
                        DatePicker::make('created_until')
                            ->label('Until')
                            ->native(false)
                            ->displayFormat('d M Y'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'] ?? null,
                                fn (Builder $q, string $date): Builder => $q->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $q, string $date): Builder => $q->whereDate('created_at', '<=', $date)
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'From: '.$data['created_from'];
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Until: '.$data['created_until'];
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    self::viewItemsAction(),

                    Action::make('invoice')
                        ->label('View Invoice')
                        ->icon(Heroicon::OutlinedDocumentText)
                        ->color('gray')
                        ->url(fn (Order $record): string => OrderResource::getUrl('invoice', ['record' => $record]))
                        ->openUrlInNewTab(),

                    Action::make('updateOrderStatus')
                        ->label('Update Order Status')
                        ->icon(Heroicon::OutlinedArrowPath)
                        ->color('warning')
                        ->fillForm(fn (Order $record): array => [
                            'order_status' => $record->order_status->value,
                        ])
                        ->form([
                            Select::make('order_status')
                                ->label('New Order Status')
                                ->options(
                                    collect(OrderStatus::cases())
                                        ->mapWithKeys(fn (OrderStatus $s): array => [$s->value => $s->name])
                                        ->toArray()
                                )
                                ->required()
                                ->native(false),
                            Textarea::make('note')
                                ->label('Note (optional)')
                                ->rows(2)
                                ->placeholder('Reason for this change…'),
                        ])
                        ->modalHeading('Update Order Status')
                        ->modalSubmitActionLabel('Update Status')
                        ->action(function (Order $record, array $data): void {
                            $oldStatus = $record->order_status;
                            $newStatus = OrderStatus::from($data['order_status']);

                            if ($oldStatus === $newStatus) {
                                Notification::make()->title('Status unchanged')->warning()->send();

                                return;
                            }

                            $updates = ['order_status' => $newStatus];

                            match ($newStatus) {
                                OrderStatus::Confirmed => $updates['confirmed_at'] = $record->confirmed_at ?? now(),
                                OrderStatus::Shipped => $updates['shipped_at'] = $record->shipped_at ?? now(),
                                OrderStatus::Delivered => $updates['delivered_at'] = $record->delivered_at ?? now(),
                                OrderStatus::Cancelled => $updates['cancelled_at'] = $record->cancelled_at ?? now(),
                                default => null,
                            };

                            $record->update($updates);

                            $record->statusHistories()->create([
                                'old_status' => $oldStatus,
                                'new_status' => $newStatus,
                                'note' => $data['note'] ?? null,
                                'changed_by' => Auth::id(),
                                'created_at' => now(),
                            ]);

                            Notification::make()
                                ->title("Status updated to {$newStatus->name}")
                                ->success()
                                ->send();
                        }),

                    Action::make('updatePaymentStatus')
                        ->label('Update Payment Status')
                        ->icon(Heroicon::OutlinedCreditCard)
                        ->color('info')
                        ->fillForm(fn (Order $record): array => [
                            'payment_status' => $record->payment_status->value,
                        ])
                        ->form([
                            Select::make('payment_status')
                                ->label('New Payment Status')
                                ->options(
                                    collect(PaymentStatus::cases())
                                        ->mapWithKeys(fn (PaymentStatus $s): array => [$s->value => $s->name])
                                        ->toArray()
                                )
                                ->required()
                                ->native(false),
                        ])
                        ->modalHeading('Update Payment Status')
                        ->modalSubmitActionLabel('Update')
                        ->action(function (Order $record, array $data): void {
                            $newStatus = PaymentStatus::from($data['payment_status']);

                            if ($record->payment_status === $newStatus) {
                                Notification::make()->title('Payment status unchanged')->warning()->send();

                                return;
                            }

                            $updates = ['payment_status' => $newStatus];

                            if ($newStatus === PaymentStatus::Paid && ! $record->paid_at) {
                                $updates['paid_at'] = now();
                            }

                            $record->update($updates);

                            Notification::make()
                                ->title("Payment status updated to {$newStatus->name}")
                                ->success()
                                ->send();
                        }),
                ])
                    ->button()
                    ->label('Actions')
                    ->icon(Heroicon::OutlinedEllipsisVertical)
                    ->extraAttributes([
                        'class' => 'self-start !items-start !mt-0',
                    ])
                    ->color('gray'),
            ])
            ->groupedBulkActions([
                BulkAction::make('markAsShipped')
                    ->label('Mark as Shipped')
                    ->icon(Heroicon::OutlinedTruck)
                    ->color('primary')
                    ->requiresConfirmation()
                    ->modalHeading('Mark selected orders as shipped?')
                    ->modalDescription('This will update the order status and record a status history entry for each order.')
                    ->action(function (Collection $records): void {
                        $records->each(function (Order $order): void {
                            if ($order->order_status === OrderStatus::Shipped) {
                                return;
                            }

                            $oldStatus = $order->order_status;

                            $order->update([
                                'order_status' => OrderStatus::Shipped,
                                'shipped_at' => $order->shipped_at ?? now(),
                            ]);

                            $order->statusHistories()->create([
                                'old_status' => $oldStatus,
                                'new_status' => OrderStatus::Shipped,
                                'note' => 'Bulk action: marked as shipped.',
                                'changed_by' => Auth::id(),
                                'created_at' => now(),
                            ]);
                        });

                        Notification::make()
                            ->title('Orders marked as shipped')
                            ->success()
                            ->send();
                    }),

                BulkAction::make('markAsDelivered')
                    ->label('Mark as Delivered')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Mark selected orders as delivered?')
                    ->modalDescription('This will update the order status and record a status history entry for each order.')
                    ->action(function (Collection $records): void {
                        $records->each(function (Order $order): void {
                            if ($order->order_status === OrderStatus::Delivered) {
                                return;
                            }

                            $oldStatus = $order->order_status;

                            $order->update([
                                'order_status' => OrderStatus::Delivered,
                                'delivered_at' => $order->delivered_at ?? now(),
                            ]);

                            $order->statusHistories()->create([
                                'old_status' => $oldStatus,
                                'new_status' => OrderStatus::Delivered,
                                'note' => 'Bulk action: marked as delivered.',
                                'changed_by' => Auth::id(),
                                'created_at' => now(),
                            ]);
                        });

                        Notification::make()
                            ->title('Orders marked as delivered')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}

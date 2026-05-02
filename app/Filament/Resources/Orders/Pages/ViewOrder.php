<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected static ?string $title = 'Order Details';

    public function mount(int|string $record): void
    {
        parent::mount($record);

        $this->redirect(OrderResource::getViewItemsModalUrl($this->record), navigate: true);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('updateOrderStatus')
                ->label('Update Order Status')
                ->icon(Heroicon::OutlinedArrowPath)
                ->color('warning')
                ->fillForm(fn (): array => [
                    'order_status' => $this->record->order_status->value,
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
                        ->label('Internal Note (optional)')
                        ->rows(2)
                        ->placeholder('Reason for status change…'),
                ])
                ->modalHeading('Update Order Status')
                ->modalSubmitActionLabel('Update Status')
                ->action(function (array $data): void {
                    /** @var Order $order */
                    $order = $this->record;
                    $oldStatus = $order->order_status;
                    $newStatus = OrderStatus::from($data['order_status']);

                    if ($oldStatus === $newStatus) {
                        Notification::make()
                            ->title('Status unchanged')
                            ->warning()
                            ->send();

                        return;
                    }

                    $updates = ['order_status' => $newStatus];

                    match ($newStatus) {
                        OrderStatus::Confirmed => $updates['confirmed_at'] = $order->confirmed_at ?? now(),
                        OrderStatus::Shipped => $updates['shipped_at'] = $order->shipped_at ?? now(),
                        OrderStatus::Delivered => $updates['delivered_at'] = $order->delivered_at ?? now(),
                        OrderStatus::Cancelled => $updates['cancelled_at'] = $order->cancelled_at ?? now(),
                        default => null,
                    };

                    $order->update($updates);

                    $order->statusHistories()->create([
                        'old_status' => $oldStatus,
                        'new_status' => $newStatus,
                        'note' => $data['note'] ?? null,
                        'changed_by' => auth()->id(),
                        'created_at' => now(),
                    ]);

                    $this->refreshFormData(['order_status', 'confirmed_at', 'shipped_at', 'delivered_at', 'cancelled_at']);

                    Notification::make()
                        ->title("Order status updated to {$newStatus->name}")
                        ->success()
                        ->send();
                }),

            Action::make('updatePaymentStatus')
                ->label('Update Payment Status')
                ->icon(Heroicon::OutlinedCreditCard)
                ->color('info')
                ->fillForm(fn (): array => [
                    'payment_status' => $this->record->payment_status->value,
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
                    Textarea::make('note')
                        ->label('Internal Note (optional)')
                        ->rows(2)
                        ->placeholder('Reason for status change…'),
                ])
                ->modalHeading('Update Payment Status')
                ->modalSubmitActionLabel('Update Payment Status')
                ->action(function (array $data): void {
                    /** @var Order $order */
                    $order = $this->record;
                    $oldStatus = $order->payment_status;
                    $newStatus = PaymentStatus::from($data['payment_status']);

                    if ($oldStatus === $newStatus) {
                        Notification::make()
                            ->title('Payment status unchanged')
                            ->warning()
                            ->send();

                        return;
                    }

                    $updates = ['payment_status' => $newStatus];

                    if ($newStatus === PaymentStatus::Paid && ! $order->paid_at) {
                        $updates['paid_at'] = now();
                    }

                    $order->update($updates);

                    Notification::make()
                        ->title("Payment status updated to {$newStatus->name}")
                        ->success()
                        ->send();
                }),

            Action::make('viewInvoice')
                ->label('View Invoice')
                ->icon(Heroicon::OutlinedDocumentText)
                ->color('gray')
                ->url(fn (): string => OrderResource::getUrl('invoice', ['record' => $this->record]))
                ->openUrlInNewTab(),
        ];
    }
}

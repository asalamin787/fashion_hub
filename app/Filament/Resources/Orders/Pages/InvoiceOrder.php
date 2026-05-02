<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Support\Icons\Heroicon;

class InvoiceOrder extends Page
{
    use InteractsWithRecord;

    protected static string $resource = OrderResource::class;

    protected string $view = 'filament.resources.orders.pages.invoice-order';

    protected static ?string $title = 'Invoice';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->authorizeAccess();

        $this->record->load(['items.product', 'user', 'payments']);
    }

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to Order')
                ->icon(Heroicon::OutlinedArrowLeft)
                ->url(OrderResource::getViewItemsModalUrl($this->record))
                ->color('gray'),
            Action::make('print')
                ->label('Print Invoice')
                ->icon(Heroicon::OutlinedPrinter)
                ->color('primary')
                ->url('#')
                ->extraAttributes([
                    'onclick' => "window.open('".route('admin.orders.invoice.print', $this->record)."', 'invoicePrint', 'width=900,height=700,scrollbars=yes'); return false;",
                ]),
        ];
    }

    protected function getViewData(): array
    {
        $order = $this->record;

        return [
            'order' => $order,
            'companyName' => config('app.name', 'Fashion Hub'),
            'companyEmail' => config('mail.from.address', 'hello@example.com'),
        ];
    }
}

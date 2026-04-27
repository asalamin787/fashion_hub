<?php

namespace App\Listeners;

use App\Services\CartService;
use Illuminate\Auth\Events\Login;

class MergeGuestCartAfterLogin
{
    /**
     * Create the event listener.
     */
    public function __construct(private readonly CartService $cartService) {}

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $this->cartService->mergeGuestCartToUserCart();
    }
}

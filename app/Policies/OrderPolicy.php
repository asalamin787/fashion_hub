<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, Order $order): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Orders are created exclusively through the checkout flow.
     */
    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Order $order): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Prevent hard deletions to preserve order integrity.
     */
    public function delete(User $user, Order $order): bool
    {
        return false;
    }

    public function forceDelete(User $user, Order $order): bool
    {
        return false;
    }

    public function restore(User $user, Order $order): bool
    {
        return false;
    }
}

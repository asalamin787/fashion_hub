<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function overview(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $orders = Order::query()
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('account.dashboard', [
            'user' => $user,
            'orders' => $orders,
            'orderCount' => Order::query()->where('user_id', $user->id)->count(),
            'pendingOrders' => Order::query()->where('user_id', $user->id)->where('order_status', 'pending')->count(),
            'completedOrders' => Order::query()->where('user_id', $user->id)->where('order_status', 'delivered')->count(),
            'spentTotal' => (float) Order::query()->where('user_id', $user->id)->sum('total_amount'),
        ]);
    }

    public function orders(): View
    {
        $orders = Order::query()
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('account.orders', [
            'orders' => $orders,
        ]);
    }

    public function orderDetails(string $orderNumber): View
    {
        $order = Order::query()
            ->where('user_id', Auth::id())
            ->where('order_number', $orderNumber)
            ->with(['items.product'])
            ->firstOrFail();

        return view('account.order_details', [
            'order' => $order,
        ]);
    }

    public function profile(): View
    {
        return view('account.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        /** @var User $user */
        $user = Auth::user();

        $user->fill([
            'name' => trim($validated['first_name'].' '.$validated['last_name']),
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);
        $user->save();

        return back()->with('success', 'Your profile has been updated successfully.');
    }

    public function addressBook(): View
    {
        return view('account.address_book', [
            'user' => Auth::user(),
        ]);
    }

    public function updateAddress(UpdateAddressRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->fill($request->validated());
        $user->save();

        return back()->with('success', 'Your address has been updated successfully.');
    }

    public function security(): View
    {
        return view('account.password', [
            'user' => Auth::user(),
        ]);
    }

    public function updatePassword(ChangePasswordRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        /** @var User $user */
        $user = Auth::user();
        $user->fill([
            'password' => Hash::make($validated['password']),
        ]);
        $user->save();

        return back()->with('success', 'Your password was changed successfully.');
    }
}

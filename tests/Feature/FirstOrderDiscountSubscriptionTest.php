<?php

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('newsletter subscription creates subscriber with first-order discount', function (): void {
    $response = $this->postJson(route('newsletter.subscribe'), [
        'email' => 'subscriber@example.com',
    ]);

    $response->assertOk()
        ->assertJson([
            'already_subscribed' => false,
        ]);

    $user = User::query()->where('email', 'subscriber@example.com')->first();

    expect($user)->not->toBeNull();
    expect($user->is_subscribed)->toBeTrue();
    expect($user->first_order_discount_available)->toBeTrue();
    expect(session('newsletter_subscriber_email'))->toBe('subscriber@example.com');
});

test('existing subscriber with previous order does not regain first-order discount', function (): void {
    $user = User::factory()->create([
        'email' => 'existing@example.com',
        'is_subscribed' => false,
        'first_order_discount_available' => true,
    ]);

    Order::query()->create([
        'order_number' => Order::generateOrderNumber(),
        'user_id' => $user->id,
        'customer_first_name' => 'Existing',
        'customer_last_name' => 'User',
        'customer_email' => $user->email,
        'customer_phone' => '1234567890',
        'country' => 'US',
        'street_address' => '123 Main St',
        'city' => 'New York',
        'state' => 'NY',
        'zip_code' => '10001',
        'payment_method' => PaymentMethod::CashOnDelivery,
        'payment_status' => PaymentStatus::Unpaid,
        'order_status' => OrderStatus::Pending,
        'subtotal' => 100,
        'shipping_amount' => 0,
        'tax_amount' => 0,
        'discount_amount' => 0,
        'total_amount' => 100,
    ]);

    $this->postJson(route('newsletter.subscribe'), [
        'email' => 'existing@example.com',
    ])->assertOk();

    $user->refresh();

    expect($user->is_subscribed)->toBeTrue();
    expect($user->first_order_discount_available)->toBeFalse();
});

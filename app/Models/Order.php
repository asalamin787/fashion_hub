<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Policies\OrderPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

#[UsePolicy(OrderPolicy::class)]
class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'order_number',
        'user_id',
        'cart_id',
        'customer_first_name',
        'customer_last_name',
        'customer_email',
        'customer_phone',
        'company_name',
        'country',
        'street_address',
        'apartment',
        'city',
        'state',
        'zip_code',
        'shipping_same_as_billing',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_phone',
        'shipping_country',
        'shipping_street_address',
        'shipping_apartment',
        'shipping_city',
        'shipping_state',
        'shipping_zip_code',
        'order_notes',
        'payment_method',
        'payment_status',
        'transaction_id',
        'stripe_payment_intent_id',
        'payment_method_id',
        'payment_gateway',
        'subtotal',
        'shipping_amount',
        'tax_amount',
        'discount_amount',
        'coupon_code',
        'first_order_discount_applied',
        'first_order_discount_rate',
        'total_amount',
        'order_status',
        'placed_at',
        'confirmed_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
        'paid_at',
        'currency',
        'exchange_rate',
        'ip_address',
        'user_agent',
        'meta',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'shipping_same_as_billing' => true,
        'payment_method' => PaymentMethod::CashOnDelivery->value,
        'payment_status' => PaymentStatus::Unpaid->value,
        'order_status' => OrderStatus::Pending->value,
        'shipping_amount' => '0.00',
        'tax_amount' => '0.00',
        'discount_amount' => '0.00',
        'first_order_discount_applied' => false,
        'currency' => 'USD',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'cart_id' => 'integer',
            'shipping_same_as_billing' => 'boolean',
            'payment_method' => PaymentMethod::class,
            'payment_status' => PaymentStatus::class,
            'order_status' => OrderStatus::class,
            'subtotal' => 'decimal:2',
            'shipping_amount' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'first_order_discount_applied' => 'boolean',
            'first_order_discount_rate' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'exchange_rate' => 'decimal:6',
            'placed_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'shipped_at' => 'datetime',
            'delivered_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'paid_at' => 'datetime',
            'meta' => 'array',
            'deleted_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $order): void {
            if (! $order->order_number) {
                $order->order_number = static::generateOrderNumber();
            }

            if (! $order->placed_at) {
                $order->placed_at = Carbon::now();
            }
        });
    }

    public static function generateOrderNumber(): string
    {
        do {
            $candidate = 'ORD-'.now()->format('Ymd').'-'.str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (static::query()->where('order_number', $candidate)->exists());

        return $candidate;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(OrderShipment::class);
    }

    public function getCustomerNameAttribute(): string
    {
        return trim($this->customer_first_name.' '.$this->customer_last_name);
    }

    public function getHasFirstOrderDiscountAttribute(): bool
    {
        return (bool) $this->first_order_discount_applied;
    }

    public function getDiscountLabelAttribute(): ?string
    {
        if ((bool) $this->first_order_discount_applied) {
            return 'First Order Discount';
        }

        if (filled($this->coupon_code)) {
            return 'Coupon ('.$this->coupon_code.')';
        }

        return null;
    }

    /**
     * @return array<string, string>
     */
    public function billingAddress(): array
    {
        return [
            'name' => $this->customer_name,
            'line_1' => $this->street_address,
            'line_2' => (string) ($this->apartment ?? ''),
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->zip_code,
            'country' => $this->country,
            'email' => $this->customer_email,
            'phone' => $this->customer_phone,
        ];
    }

    /**
     * @return array<string, string>
     */
    public function shippingAddress(): array
    {
        if ($this->shipping_same_as_billing) {
            return $this->billingAddress();
        }

        return [
            'name' => trim(($this->shipping_first_name ?? '').' '.($this->shipping_last_name ?? '')),
            'line_1' => (string) $this->shipping_street_address,
            'line_2' => (string) ($this->shipping_apartment ?? ''),
            'city' => (string) $this->shipping_city,
            'state' => (string) $this->shipping_state,
            'postal_code' => (string) $this->shipping_zip_code,
            'country' => (string) $this->shipping_country,
            'email' => $this->customer_email,
            'phone' => (string) ($this->shipping_phone ?? $this->customer_phone),
        ];
    }
}

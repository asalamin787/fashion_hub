<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'cart_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'product_name',
        'variant_label',
        'sku',
        'price',
        'image',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Resolve the variant payload from the related product's JSON variants.
     *
     * @return array<string, mixed>|null
     */
    public function getProductVariantAttribute(): ?array
    {
        if (! $this->product_variant_id) {
            return null;
        }

        /** @var Product|null $product */
        $product = $this->product;

        if (! $product) {
            return null;
        }

        $variant = collect($product->variants ?? [])->first(
            fn (mixed $row): bool => is_array($row) && (string) ($row['sku'] ?? '') === (string) $this->product_variant_id,
        );

        return is_array($variant) ? $variant : null;
    }

    /** Price × quantity for this line item. */
    public function getLineTotalAttribute(): string
    {
        return number_format((float) $this->price * $this->quantity, 2, '.', '');
    }
}

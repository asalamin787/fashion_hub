<?php

namespace App\Models;

use App\Policies\ProductReviewPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

#[UsePolicy(ProductReviewPolicy::class)]
class ProductReview extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'order_item_id',
        'rating',
        'title',
        'review',
        'images',
        'status',
        'approved_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'product_id' => 'integer',
            'order_id' => 'integer',
            'order_item_id' => 'integer',
            'rating' => 'integer',
            'images' => 'array',
            'approved_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saved(function (self $review): void {
            if ($review->relationLoaded('product') && $review->product instanceof Product) {
                static::refreshProductReviewStats($review->product);

                return;
            }

            $product = Product::query()->find($review->product_id);

            if ($product) {
                static::refreshProductReviewStats($product);
            }
        });

        static::deleted(function (self $review): void {
            $product = Product::query()->find($review->product_id);

            if ($product) {
                static::refreshProductReviewStats($product);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function approve(): void
    {
        $this->forceFill([
            'status' => 'approved',
            'approved_at' => Carbon::now(),
        ])->save();
    }

    public function reject(): void
    {
        $this->forceFill([
            'status' => 'rejected',
            'approved_at' => null,
        ])->save();
    }

    public static function refreshProductReviewStats(Product $product): void
    {
        $approvedReviews = $product->reviews()->approved();
        $reviewCount = (int) $approvedReviews->count();
        $average = $reviewCount > 0 ? (float) $approvedReviews->avg('rating') : 0.0;

        $product->forceFill([
            'rating' => $average,
        ])->saveQuietly();
    }
}

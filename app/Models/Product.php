<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'category_id',
        'brand_id',
        'status',
        'badge',
        'featured_image',
        'gallery_images',
        'has_variants',
        'base_price',
        'sale_price',
        'stock',
        'attributes',
        'variants',
        'seo',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => 'draft',
        'has_variants' => false,
        'stock' => 0,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gallery_images' => 'array',
            'attributes' => 'array',
            'variants' => 'array',
            'seo' => 'array',
            'has_variants' => 'boolean',
            'base_price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'deleted_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function bags(): BelongsToMany
    {
        return $this->belongsToMany(Bag::class);
    }

    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getDefaultVariantAttribute(): ?array
    {
        $variants = collect($this->getAttribute('variants') ?? [])
            ->filter(fn (mixed $variant): bool => is_array($variant));

        $defaultVariant = $variants->first(fn (array $variant): bool => (bool) ($variant['is_default'] ?? false));

        if (is_array($defaultVariant)) {
            return $defaultVariant;
        }

        $availableVariant = $variants->first(fn (array $variant): bool => ($variant['status'] ?? 'active') === 'active');

        return is_array($availableVariant) ? $availableVariant : $variants->first();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getAvailableVariantsAttribute(): array
    {
        return collect($this->getAttribute('variants') ?? [])
            ->filter(fn (mixed $variant): bool => is_array($variant))
            ->filter(fn (array $variant): bool => ($variant['status'] ?? 'active') === 'active')
            ->filter(fn (array $variant): bool => (int) ($variant['stock'] ?? 0) > 0)
            ->values()
            ->all();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getVariantDisplayRowsAttribute(): array
    {
        return collect($this->getAttribute('variants') ?? [])
            ->filter(fn (mixed $variant): bool => is_array($variant))
            ->map(function (array $variant): array {
                $variant['combination_label'] = static::formatVariantLabel($variant);

                return $variant;
            })
            ->values()
            ->all();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getAttributeDisplayRowsAttribute(): array
    {
        return collect($this->getAttribute('attributes') ?? [])
            ->filter(fn (mixed $attribute): bool => is_array($attribute))
            ->map(function (array $attribute): array {
                $attribute['values_label'] = collect($attribute['values'] ?? [])
                    ->filter(fn (mixed $value): bool => is_array($value))
                    ->map(fn (array $value): string => $value['label'] ?? $value['value'] ?? '')
                    ->filter()
                    ->implode(', ');

                return $attribute;
            })
            ->values()
            ->all();
    }

    /**
     * @return array{min: float, max: float}|null
     */
    public function getPriceRangeAttribute(): ?array
    {
        if (! $this->has_variants) {
            $effectivePrice = $this->getEffectivePriceAttribute();

            if ($effectivePrice === null) {
                return null;
            }

            return [
                'min' => $effectivePrice,
                'max' => $effectivePrice,
            ];
        }

        $prices = collect($this->getAttribute('variants') ?? [])
            ->filter(fn (mixed $variant): bool => is_array($variant))
            ->filter(fn (array $variant): bool => ($variant['status'] ?? 'active') === 'active')
            ->map(function (array $variant): ?float {
                $basePrice = static::normalizeNumber($variant['price'] ?? null);

                if ($basePrice === null) {
                    return null;
                }

                if ($this->isVariantOnSale($variant)) {
                    return static::normalizeNumber($variant['sale_price'] ?? null) ?? $basePrice;
                }

                return $basePrice;
            })
            ->filter(fn (?float $price): bool => $price !== null)
            ->values();

        if ($prices->isEmpty()) {
            return null;
        }

        return [
            'min' => (float) $prices->min(),
            'max' => (float) $prices->max(),
        ];
    }

    public function getEffectivePriceAttribute(): ?float
    {
        if (! $this->has_variants) {
            $basePrice = static::normalizeNumber($this->base_price);
            $salePrice = static::normalizeNumber($this->sale_price);

            if ($salePrice !== null && $basePrice !== null && $salePrice <= $basePrice) {
                return $salePrice;
            }

            return $basePrice;
        }

        $variant = $this->default_variant;

        if (! is_array($variant)) {
            return null;
        }

        $variantPrice = static::normalizeNumber($variant['price'] ?? null);

        if ($variantPrice === null) {
            return null;
        }

        if ($this->isVariantOnSale($variant)) {
            return static::normalizeNumber($variant['sale_price'] ?? null) ?? $variantPrice;
        }

        return $variantPrice;
    }

    /**
     * @param  array<string, mixed>  $variant
     */
    public function isVariantOnSale(array $variant): bool
    {
        $price = static::normalizeNumber($variant['price'] ?? null);
        $salePrice = static::normalizeNumber($variant['sale_price'] ?? null);

        if ($price === null || $salePrice === null || $salePrice > $price) {
            return false;
        }

        $saleStartAt = static::parseDate($variant['sale_start_at'] ?? null);
        $saleEndAt = static::parseDate($variant['sale_end_at'] ?? null);

        if ($saleStartAt !== null && $saleEndAt !== null && $saleStartAt->gt($saleEndAt)) {
            return false;
        }

        $now = now();

        if ($saleStartAt !== null && $now->lt($saleStartAt)) {
            return false;
        }

        if ($saleEndAt !== null && $now->gt($saleEndAt)) {
            return false;
        }

        return true;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function generateVariantsFromAttributes(): array
    {
        $variantAttributes = collect($this->getAttribute('attributes') ?? [])
            ->filter(fn (mixed $attribute): bool => is_array($attribute))
            ->map(function (array $attribute): ?array {
                $slug = Str::slug((string) ($attribute['slug'] ?? $attribute['name'] ?? ''));
                $name = trim((string) ($attribute['name'] ?? ''));
                $displayType = ($attribute['display_type'] ?? 'text') === 'image' ? 'image' : 'text';

                $values = collect($attribute['values'] ?? [])
                    ->filter(fn (mixed $value): bool => is_array($value))
                    ->map(function (array $value) use ($displayType): ?array {
                        $label = trim((string) ($value['label'] ?? ''));
                        $normalizedValue = trim((string) ($value['value'] ?? ''));

                        if (blank($label) || blank($normalizedValue)) {
                            return null;
                        }

                        return [
                            'label' => $label,
                            'value' => $normalizedValue,
                            'image' => $displayType === 'image' ? ($value['image'] ?? null) : null,
                        ];
                    })
                    ->filter()
                    ->values()
                    ->all();

                if (blank($slug) || blank($name) || $values === []) {
                    return null;
                }

                return [
                    'name' => $name,
                    'slug' => $slug,
                    'display_type' => $displayType,
                    'values' => $values,
                ];
            })
            ->filter()
            ->values();

        if ($variantAttributes->isEmpty()) {
            $this->variants = [];

            return [];
        }

        $existingVariants = collect($this->getAttribute('variants') ?? [])
            ->filter(fn (mixed $variant): bool => is_array($variant))
            ->reduce(function (array $carry, array $variant): array {
                $key = static::buildVariantKey($variant['attributes'] ?? []);

                if (filled($key) && ! array_key_exists($key, $carry)) {
                    $carry[$key] = $variant;
                }

                return $carry;
            }, []);

        $combinations = static::buildCombinations($variantAttributes->all());

        $variants = collect($combinations)
            ->map(function (array $combination) use ($existingVariants): array {
                $attributeValues = [];
                $attributeLabels = [];

                foreach ($combination as $item) {
                    $attributeValues[$item['slug']] = $item['value'];
                    $attributeLabels[$item['slug']] = $item['label'];
                }

                $variantKey = static::buildVariantKey($attributeValues);
                $existingVariant = $existingVariants[$variantKey] ?? [];
                $basePrice = static::normalizeNumber($this->base_price);
                $salePrice = static::normalizeNumber($this->sale_price);

                return [
                    'id' => (string) ($existingVariant['id'] ?? (string) Str::uuid()),
                    'sku' => (string) ($existingVariant['sku'] ?? static::generateSku(
                        (string) ($this->slug ?: $this->name ?: 'product'),
                        $attributeValues,
                    )),
                    'barcode' => $existingVariant['barcode'] ?? null,
                    'attributes' => $attributeValues,
                    'attribute_labels' => $attributeLabels,
                    'price' => static::normalizeNumber($existingVariant['price'] ?? null) ?? $basePrice,
                    'sale_price' => static::normalizeNumber($existingVariant['sale_price'] ?? null) ?? $salePrice,
                    'sale_start_at' => $existingVariant['sale_start_at'] ?? null,
                    'sale_end_at' => $existingVariant['sale_end_at'] ?? null,
                    'stock' => (int) ($existingVariant['stock'] ?? $this->stock ?? 0),
                    'low_stock_alert' => (int) ($existingVariant['low_stock_alert'] ?? 0),
                    'image' => $existingVariant['image'] ?? null,
                    'is_default' => (bool) ($existingVariant['is_default'] ?? false),
                    'status' => static::normalizeVariantStatus($existingVariant['status'] ?? 'active'),
                ];
            })
            ->values();

        $defaultIndex = $variants->search(fn (array $variant): bool => (bool) ($variant['is_default'] ?? false));

        if ($defaultIndex === false && $variants->isNotEmpty()) {
            $defaultIndex = 0;
        }

        if ($defaultIndex !== false) {
            $variants = $variants->map(function (array $variant, int $index) use ($defaultIndex): array {
                $variant['is_default'] = $index === $defaultIndex;

                return $variant;
            })->values();
        }

        $this->variants = $variants->all();

        return $this->variants;
    }

    /**
     * @param  array<string, mixed>  $variant
     */
    public static function formatVariantLabel(array $variant): string
    {
        $attributeLabels = is_array($variant['attribute_labels'] ?? null) ? $variant['attribute_labels'] : [];
        $attributes = is_array($variant['attributes'] ?? null) ? $variant['attributes'] : [];

        return static::formatAttributePairs($attributeLabels, $attributes);
    }

    /**
     * @param  array<string, mixed>  $attributeLabels
     * @param  array<string, mixed>  $attributes
     */
    public static function formatAttributePairs(array $attributeLabels, array $attributes): string
    {
        $segments = [];

        foreach ($attributes as $slug => $value) {
            $label = $attributeLabels[$slug] ?? $value;
            $segments[] = Str::headline((string) $slug).': '.$label;
        }

        return $segments === [] ? 'Variant' : implode(' / ', $segments);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public static function buildVariantKey(array $attributes): string
    {
        ksort($attributes);

        return collect($attributes)
            ->map(fn (mixed $value, string $key): string => Str::slug($key).':'.Str::slug((string) $value))
            ->implode('|');
    }

    /**
     * @param  list<array{name: string, slug: string, display_type: string, values: list<array{label: string, value: string, image: string|null}>}>  $attributes
     * @return list<list<array{slug: string, label: string, value: string}>>
     */
    protected static function buildCombinations(array $attributes): array
    {
        $combinations = [[]];

        foreach ($attributes as $attribute) {
            $nextCombinations = [];

            foreach ($combinations as $combination) {
                foreach ($attribute['values'] as $value) {
                    $nextCombinations[] = [
                        ...$combination,
                        [
                            'slug' => $attribute['slug'],
                            'label' => $value['label'],
                            'value' => $value['value'],
                        ],
                    ];
                }
            }

            $combinations = $nextCombinations;
        }

        return $combinations;
    }

    protected static function generateSku(string $base, array $attributes): string
    {
        $segments = [
            static::sanitizeSkuSegment($base),
            ...collect($attributes)
                ->map(fn (mixed $value): string => static::sanitizeSkuSegment((string) $value))
                ->values()
                ->all(),
        ];

        return implode('-', array_filter($segments));
    }

    protected static function sanitizeSkuSegment(string $value): string
    {
        $normalized = Str::upper(Str::slug($value, '-'));

        return $normalized === '' ? 'ITEM' : $normalized;
    }

    protected static function normalizeVariantStatus(?string $status): string
    {
        return in_array($status, ['active', 'inactive'], true) ? $status : 'active';
    }

    protected static function normalizeNumber(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return round((float) $value, 2);
    }

    protected static function parseDate(mixed $value): ?Carbon
    {
        if (blank($value)) {
            return null;
        }

        try {
            return Carbon::parse($value);
        } catch (\Throwable) {
            return null;
        }
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        $image = (string) ($this->featured_image ?? '');

        if ($image === '') {
            return 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=400';
        }

        if (Str::startsWith($image, ['http://', 'https://'])) {
            return $image;
        }

        return asset('storage/'.ltrim($image, '/'));
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory(Builder $query, int|array|null $categoryId): Builder
    {
        if ($categoryId === null) {
            return $query;
        }

        if (is_array($categoryId)) {
            return $query->whereIn('category_id', $categoryId);
        }

        return $query->where('category_id', $categoryId);
    }

    public function scopeByBrand(Builder $query, int|array|null $brandId): Builder
    {
        if ($brandId === null) {
            return $query;
        }

        if (is_array($brandId)) {
            return $query->whereIn('brand_id', $brandId);
        }

        return $query->where('brand_id', $brandId);
    }

    public function scopeByBadge(Builder $query, string|array|null $badge): Builder
    {
        if ($badge === null) {
            return $query;
        }

        if (is_array($badge)) {
            return $query->whereIn('badge', $badge);
        }

        return $query->where('badge', $badge);
    }

    public function scopeByOfferCode(Builder $query, string|array|null $offerCode): Builder
    {
        if ($offerCode === null) {
            return $query;
        }

        $offerCodes = is_array($offerCode) ? array_values(array_filter($offerCode)) : [$offerCode];

        if ($offerCodes === []) {
            return $query;
        }

        return $query->whereHas('offers', function (Builder $offerQuery) use ($offerCodes): void {
            $offerQuery->whereIn('code', $offerCodes);
        });
    }

    public function scopeByPriceRange(Builder $query, ?float $minPrice = null, ?float $maxPrice = null): Builder
    {
        if ($minPrice !== null) {
            $query->where(function (Builder $q) use ($minPrice): void {
                $q->whereRaw('COALESCE(sale_price, base_price) >= ?', [$minPrice])
                    ->orWhereRaw('base_price >= ?', [$minPrice]);
            });
        }

        if ($maxPrice !== null) {
            $query->where(function (Builder $q) use ($maxPrice): void {
                $q->whereRaw('COALESCE(sale_price, base_price) <= ?', [$maxPrice])
                    ->orWhereRaw('base_price <= ?', [$maxPrice]);
            });
        }

        return $query;
    }

    public function scopeSort(Builder $query, ?string $sortBy = 'featured'): Builder
    {
        return match ($sortBy) {
            'price_low' => $query->orderByRaw('COALESCE(sale_price, base_price)')->orderBy('id'),
            'price_high' => $query->orderByRaw('COALESCE(sale_price, base_price) DESC')->orderBy('id', 'desc'),
            'newest' => $query->orderByDesc('created_at')->orderByDesc('id'),
            'best_selling' => $query->orderByDesc('sales_count')->orderByDesc('id'),
            'top_rated' => $query->orderByDesc('rating')->orderByDesc('id'),
            default => $query->orderByDesc('is_featured')->orderByDesc('sales_count')->orderByDesc('id'),
        };
    }
}

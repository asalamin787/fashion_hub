<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::query()->first();
        $fashionHubBrand = Brand::query()->where('slug', 'fashionhub-premium')->first();
        $urbanBrand = Brand::query()->where('slug', 'urban-style')->first();

        $variantProduct = Product::query()->updateOrCreate(
            ['slug' => 'classic-crew-tee'],
            [
                'name' => 'Classic Crew Tee',
                'short_description' => 'A soft everyday tee with generated size and style variants.',
                'description' => 'This classic cotton crew tee is set up as a multi-variation product that stores attributes and variants directly in the products table as JSON.',
                'category_id' => $category?->id,
                'brand_id' => $fashionHubBrand?->id,
                'status' => 'active',
                'has_variants' => true,
                'base_price' => 1200,
                'sale_price' => 999,
                'stock' => 0,
                'attributes' => [
                    [
                        'name' => 'Size',
                        'slug' => 'size',
                        'display_type' => 'text',
                        'values' => [
                            ['label' => 'Small', 'value' => 'S'],
                            ['label' => 'Medium', 'value' => 'M'],
                        ],
                    ],
                    [
                        'name' => 'Style',
                        'slug' => 'style',
                        'display_type' => 'image',
                        'values' => [
                            ['label' => 'Black', 'value' => 'black', 'image' => null],
                            ['label' => 'Stone', 'value' => 'stone', 'image' => null],
                        ],
                    ],
                ],
                'seo' => [
                    'meta_title' => 'Classic Crew Tee | Fashion Hub',
                    'meta_description' => 'A variant-ready crew neck tee with size and style combinations stored in JSON.',
                    'meta_keywords' => 'crew tee, cotton t-shirt, variant product',
                    'canonical_url' => 'https://fashionhub.test/products/classic-crew-tee',
                ],
            ],
        );

        $variantProduct->variants = collect($variantProduct->generateVariantsFromAttributes())
            ->map(function (array $variant, int $index): array {
                $variant['price'] = 1200 + ($index * 50);
                $variant['sale_price'] = $index === 0 ? 999 : null;
                $variant['stock'] = 10 - ($index * 2);
                $variant['low_stock_alert'] = 2;
                $variant['status'] = 'active';
                $variant['is_default'] = $index === 0;

                return $variant;
            })
            ->all();
        $variantProduct->save();

        Product::query()->updateOrCreate(
            ['slug' => 'minimal-linen-shirt'],
            [
                'name' => 'Minimal Linen Shirt',
                'short_description' => 'Simple product example without variant-level inventory.',
                'description' => 'A clean simple product record using base price and stock at the product level.',
                'category_id' => $category?->id,
                'brand_id' => $urbanBrand?->id,
                'status' => 'active',
                'has_variants' => false,
                'base_price' => 1850,
                'sale_price' => 1650,
                'stock' => 24,
                'seo' => [
                    'meta_title' => 'Minimal Linen Shirt | Fashion Hub',
                    'meta_description' => 'Simple product example seeded with product-level pricing and stock.',
                ],
            ],
        );
    }
}

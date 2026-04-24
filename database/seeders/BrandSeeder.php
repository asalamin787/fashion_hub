<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'FashionHub Premium',
                'website' => 'https://fashionhub.test',
                'description' => 'Premium essentials and elevated everyday fashion pieces.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Urban Style',
                'website' => 'https://urbanstyle.test',
                'description' => 'Street-inspired looks and modern wardrobe staples.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Classic Wear',
                'website' => 'https://classicwear.test',
                'description' => 'Timeless silhouettes with comfortable materials.',
                'sort_order' => 3,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::query()->updateOrCreate(
                ['slug' => Str::slug($brand['name'])],
                [
                    ...$brand,
                    'slug' => Str::slug($brand['name']),
                    'is_active' => true,
                ],
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => "Men's Fashion",
                'description' => 'Modern menswear essentials including shirts, trousers, jackets, and everyday style staples.',
                'icon' => 'fas fa-male',
                'sort_order' => 1,
                'image' => 'https://images.unsplash.com/photo-1490114538077-0a7f8cb49891?w=600',
            ],
            [
                'name' => "Women's Fashion",
                'description' => 'Elegant women\'s fashion featuring dresses, tops, bottoms, and curated seasonal styles.',
                'icon' => 'fas fa-female',
                'sort_order' => 2,
                'image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=600',
            ],
            [
                'name' => 'Accessories',
                'description' => 'Style-finishing accessories including scarves, belts, small leather goods, and statement pieces.',
                'icon' => 'fas fa-gem',
                'sort_order' => 3,
                'image' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=600',
            ],
            [
                'name' => 'Footwear',
                'description' => 'Comfortable and stylish footwear for casual, formal, and everyday wear.',
                'icon' => 'fas fa-shoe-prints',
                'sort_order' => 4,
                'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=600',
            ],
            [
                'name' => 'Bags & Purses',
                'description' => 'Functional and fashionable bags, totes, purses, and crossbody essentials for every occasion.',
                'icon' => 'fas fa-shopping-bag',
                'sort_order' => 5,
                'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=600',
            ],
            [
                'name' => 'Eyewear',
                'description' => 'Fashion eyewear and sunglasses designed to complete your look with confidence.',
                'icon' => 'fas fa-glasses',
                'sort_order' => 6,
                'image' => 'https://images.unsplash.com/photo-1509319117443-4b901b5414cc?w=600',
            ],
            [
                'name' => 'Watches',
                'description' => 'Classic and contemporary watches that combine precision, utility, and timeless style.',
                'icon' => 'fas fa-watch',
                'sort_order' => 7,
                'image' => 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?w=600',
            ],
            [
                'name' => 'Jewelry',
                'description' => 'Rings, necklaces, bracelets, and refined jewelry pieces to elevate every outfit.',
                'icon' => 'fas fa-ring',
                'sort_order' => 8,
                'image' => 'https://images.unsplash.com/photo-1611652022419-a9419f74343d?w=600',
            ],
        ];

        foreach ($categories as $categoryData) {
            $slug = Str::slug($categoryData['name']);

            Category::query()->updateOrCreate([
                'slug' => $slug,
            ], [
                'name' => $categoryData['name'],
                'slug' => $slug,
                'description' => $categoryData['description'],
                'icon' => $categoryData['icon'],
                'sort_order' => $categoryData['sort_order'],
                'image' => $categoryData['image'],
                'is_active' => true,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => "Women's Clothing",
                'description' => 'Latest fashion trends for women including dresses, tops, bottoms, and accessories.',
                'icon' => 'heroicon-o-shirt',
                'sort_order' => 1,
            ],
            [
                'name' => "Men's Fashion",
                'description' => 'Premium collection of men\'s clothing, shoes, and accessories.',
                'icon' => 'heroicon-o-shirt',
                'sort_order' => 2,
            ],
            [
                'name' => 'Footwear',
                'description' => 'Comfortable and stylish shoes for all occasions.',
                'icon' => 'heroicon-o-tag',
                'sort_order' => 3,
            ],
            [
                'name' => 'Accessories',
                'description' => 'Complete your look with our collection of bags, belts, scarves, and more.',
                'icon' => 'heroicon-o-squares-2x2',
                'sort_order' => 4,
            ],
            [
                'name' => 'Activewear',
                'description' => 'Sport and fitness clothing for your active lifestyle.',
                'icon' => 'heroicon-o-shirt',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $categoryData) {
            $image = $this->generatePlaceholderImage(
                $categoryData['name'],
                'categories'
            );

            Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
                'icon' => $categoryData['icon'],
                'sort_order' => $categoryData['sort_order'],
                'image' => $image,
                'is_active' => true,
            ]);
        }
    }

    private function generatePlaceholderImage(string $text, string $directory): string
    {
        $publicPath = storage_path('app/public/'.$directory);

        if (! File::isDirectory($publicPath)) {
            File::makeDirectory($publicPath, 0755, true);
        }

        // Create a simple colored placeholder image
        $filename = Str::slug($text).'_'.time().'.png';

        $image = imagecreatetruecolor(400, 300);
        $colors = [
            imagecolorallocate($image, 255, 107, 107), // Red
            imagecolorallocate($image, 107, 142, 255), // Blue
            imagecolorallocate($image, 255, 195, 0),   // Gold
            imagecolorallocate($image, 107, 255, 107), // Green
            imagecolorallocate($image, 255, 107, 197), // Pink
        ];

        $backgroundColor = $colors[array_rand($colors)];
        $textColor = imagecolorallocate($image, 255, 255, 255); // White text

        imagefilledrectangle($image, 0, 0, 400, 300, $backgroundColor);
        imagestring($image, 5, 50, 140, $text, $textColor);

        imagepng($image, $publicPath.'/'.$filename);
        imagedestroy($image);

        return $directory.'/'.$filename;
    }
}

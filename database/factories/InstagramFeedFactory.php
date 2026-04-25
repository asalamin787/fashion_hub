<?php

namespace Database\Factories;

use App\Models\InstagramFeed;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<InstagramFeed>
 */
class InstagramFeedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = [
            'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=400',
            'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=400',
            'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400',
            'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=400',
            'https://images.unsplash.com/photo-1485230895905-ec40ba36b9bc?w=400',
            'https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?w=400',
        ];

        return [
            'section_title' => 'Follow Us on Instagram',
            'instagram_handle' => '@fashionhub',
            'image' => Arr::random($images),
            'post_url' => 'https://instagram.com/fashionhub',
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 30),
        ];
    }
}

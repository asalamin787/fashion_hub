<?php

namespace Database\Factories;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<Slider>
 */
class SliderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $slides = [
            [
                'subtitle' => 'New Collection 2025',
                'title' => 'Discover Your Style',
                'description' => 'Explore our curated collection of premium fashion pieces that define elegance and sophistication.',
                'background_image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1920',
                'primary_button_text' => 'Shop Now',
                'primary_button_link' => '/shop',
                'secondary_button_text' => 'Learn More',
                'secondary_button_link' => '/about',
            ],
            [
                'subtitle' => 'Summer Collection',
                'title' => 'Up to 50% Off',
                'description' => 'Limited time offer on selected summer fashion items. Don\'t miss out on these amazing deals!',
                'background_image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1920',
                'primary_button_text' => 'Shop Sale',
                'primary_button_link' => '/shop',
                'secondary_button_text' => 'View Collection',
                'secondary_button_link' => '/shop',
            ],
            [
                'subtitle' => 'Trending Now',
                'title' => 'Fashion Forward',
                'description' => 'Stay ahead with the latest trends in fashion. Express yourself with our exclusive designs.',
                'background_image' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1920',
                'primary_button_text' => 'Explore Trends',
                'primary_button_link' => '/shop',
                'secondary_button_text' => 'Fashion Tips',
                'secondary_button_link' => '/blog',
            ],
        ];

        $slide = Arr::random($slides);

        return [
            ...$slide,
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}

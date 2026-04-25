<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(fake()->numberBetween(5, 9));

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'category' => fake()->randomElement([
                'Fashion Trends',
                'Style Guide',
                'Sustainability',
                'Shopping Tips',
                'Designer Spotlight',
            ]),
            'author_name' => fake()->name(),
            'excerpt' => fake()->paragraph(),
            'content' => implode("\n\n", fake()->paragraphs(6)),
            'featured_image' => fake()->imageUrl(1200, 700, 'fashion', true),
            'tags' => fake()->randomElements([
                'Fashion',
                'Style',
                'Trends',
                'Winter',
                'Sustainable',
                'Shopping',
                'Tips',
                'Designer',
                'Lifestyle',
                'Wardrobe',
            ], fake()->numberBetween(3, 6)),
            'publish_date' => fake()->dateTimeBetween('-4 months', '+10 days'),
            'comments_count' => fake()->numberBetween(0, 45),
            'views_count' => fake()->numberBetween(100, 8000),
            'is_published' => fake()->boolean(85),
            'sort_order' => fake()->numberBetween(0, 50),
        ];
    }
}

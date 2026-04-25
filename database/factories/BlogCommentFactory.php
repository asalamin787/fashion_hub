<?php

namespace Database\Factories;

use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BlogComment>
 */
class BlogCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'blog_post_id' => BlogPost::factory(),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'website' => fake()->optional()->url(),
            'content' => fake()->paragraph(),
            'admin_reply' => null,
            'replied_at' => null,
            'is_approved' => true,
        ];
    }
}

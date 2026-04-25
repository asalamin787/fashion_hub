<?php

namespace Database\Factories;

use App\Models\Bag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Bag>
 */
class BagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(rand(2, 3), true);

        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => fake()->optional()->sentence(),
            'is_active' => true,
        ];
    }
}

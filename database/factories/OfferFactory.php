<?php

namespace Database\Factories;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['percentage', 'fixed']);

        return [
            'title' => fake()->words(3, true),
            'code' => strtoupper(fake()->unique()->lexify('OFFER-????')),
            'description' => fake()->optional()->sentence(),
            'image' => fake()->imageUrl(1200, 600, 'fashion', true),
            'type' => $type,
            'value' => $type === 'percentage' ? fake()->numberBetween(5, 50) : fake()->numberBetween(50, 500),
            'min_order_amount' => fake()->optional()->numberBetween(200, 1000),
            'max_discount_amount' => $type === 'percentage' ? fake()->optional()->numberBetween(100, 500) : null,
            'is_active' => true,
            'starts_at' => now()->subDays(fake()->numberBetween(0, 5)),
            'expires_at' => now()->addDays(fake()->numberBetween(7, 30)),
        ];
    }
}

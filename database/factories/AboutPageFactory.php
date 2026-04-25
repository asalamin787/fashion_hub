<?php

namespace Database\Factories;

use App\Models\AboutPage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AboutPage>
 */
class AboutPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hero_title' => 'About FashionHub',
            'hero_subtitle' => 'Bringing you timeless style and exceptional quality since 2015',
            'story_title' => 'Our Story',
            'story_body' => "Founded in 2015, FashionHub began with a simple vision: to make high-quality, stylish fashion accessible to everyone.\n\nWe believe that fashion is more than just clothing-it's a form of self-expression.\n\nToday, we serve thousands of satisfied customers globally, offering an ever-expanding range of fashion-forward pieces.",
            'story_image' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=600',
            'values_title' => 'Our Values',
            'values_subtitle' => 'What drives us every day',
            'values_items' => [
                [
                    'icon' => 'fas fa-gem',
                    'title' => 'Quality First',
                    'description' => 'We source only the finest materials and work with skilled artisans to ensure every piece meets our exacting standards.',
                ],
                [
                    'icon' => 'fas fa-leaf',
                    'title' => 'Sustainability',
                    'description' => 'We\'re committed to ethical fashion practices and sustainable production methods that respect our planet.',
                ],
                [
                    'icon' => 'fas fa-heart',
                    'title' => 'Customer Satisfaction',
                    'description' => 'Your happiness is our priority. We go above and beyond to ensure you love every purchase.',
                ],
            ],
            'team_title' => 'Meet Our Team',
            'team_subtitle' => 'The faces behind FashionHub',
            'team_members' => [
                [
                    'name' => 'Sarah Anderson',
                    'role' => 'Founder & CEO',
                    'image' => 'https://randomuser.me/api/portraits/women/32.jpg',
                    'linkedin' => '#',
                    'twitter' => '#',
                    'instagram' => '#',
                ],
                [
                    'name' => 'Michael Chen',
                    'role' => 'Creative Director',
                    'image' => 'https://randomuser.me/api/portraits/men/22.jpg',
                    'linkedin' => '#',
                    'twitter' => '#',
                    'instagram' => '#',
                ],
                [
                    'name' => 'Emma Wilson',
                    'role' => 'Head of Marketing',
                    'image' => 'https://randomuser.me/api/portraits/women/44.jpg',
                    'linkedin' => '#',
                    'twitter' => '#',
                    'instagram' => '#',
                ],
                [
                    'name' => 'James Rodriguez',
                    'role' => 'Operations Manager',
                    'image' => 'https://randomuser.me/api/portraits/men/46.jpg',
                    'linkedin' => '#',
                    'twitter' => '#',
                    'instagram' => '#',
                ],
            ],
            'stats_items' => [
                [
                    'value' => '10K+',
                    'label' => 'Happy Customers',
                ],
                [
                    'value' => '500+',
                    'label' => 'Products',
                ],
                [
                    'value' => '50+',
                    'label' => 'Countries',
                ],
                [
                    'value' => '9+',
                    'label' => 'Years Experience',
                ],
            ],
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}

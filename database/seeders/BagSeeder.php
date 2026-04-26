<?php

namespace Database\Seeders;

use App\Models\Bag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BagSeeder extends Seeder
{
    public function run(): void
    {
        $bags = [
            [
                'name' => 'Tote Bags',
                'description' => 'Spacious everyday tote bags for work, shopping, and daily essentials.',
                'is_active' => true,
            ],
            [
                'name' => 'Crossbody Bags',
                'description' => 'Compact crossbody bags with adjustable straps for hands-free comfort.',
                'is_active' => true,
            ],
            [
                'name' => 'Shoulder Bags',
                'description' => 'Classic shoulder bags that balance elegance and practical storage.',
                'is_active' => true,
            ],
            [
                'name' => 'Clutches',
                'description' => 'Minimal clutches designed for parties, dinners, and formal occasions.',
                'is_active' => true,
            ],
            [
                'name' => 'Backpacks',
                'description' => 'Modern backpacks with organized compartments for travel and daily use.',
                'is_active' => true,
            ],
            [
                'name' => 'Satchel Bags',
                'description' => 'Structured satchel bags for a polished, office-ready look.',
                'is_active' => true,
            ],
            [
                'name' => 'Wallet Bags',
                'description' => 'Slim wallet-style bags for carrying cards, cash, and compact essentials.',
                'is_active' => true,
            ],
            [
                'name' => 'Mini Bags',
                'description' => 'Trendy mini bags for lightweight carry with statement style.',
                'is_active' => true,
            ],
        ];

        foreach ($bags as $bagData) {
            $slug = Str::slug($bagData['name']);

            Bag::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $bagData['name'],
                    'slug' => $slug,
                    'description' => $bagData['description'],
                    'is_active' => $bagData['is_active'],
                ],
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        $offers = [
            [
                'title' => 'Summer Sale',
                'code' => 'SUMMER50',
                'description' => 'Up to 50% off on selected items',
                'image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=600',
                'type' => 'percentage',
                'value' => 50,
                'min_order_amount' => 100,
                'max_discount_amount' => 500,
                'is_active' => true,
                'starts_at' => now()->subDay(),
                'expires_at' => now()->addMonths(2),
            ],
            [
                'title' => 'New Arrivals',
                'code' => 'NEWARRIVAL20',
                'description' => 'Discover the latest trends in fashion',
                'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=600',
                'type' => 'percentage',
                'value' => 20,
                'min_order_amount' => 80,
                'max_discount_amount' => 300,
                'is_active' => true,
                'starts_at' => now()->subDay(),
                'expires_at' => now()->addMonths(3),
            ],
        ];

        foreach ($offers as $offerData) {
            $offer = Offer::query()->updateOrCreate(
                ['code' => $offerData['code']],
                $offerData,
            );

            $productIds = match ($offer->code) {
                'SUMMER50' => Product::query()
                    ->where('status', 'active')
                    ->whereNotNull('sale_price')
                    ->pluck('id')
                    ->all(),
                'NEWARRIVAL20' => Product::query()
                    ->where('status', 'active')
                    ->where('badge', 'New')
                    ->pluck('id')
                    ->all(),
                default => [],
            };

            $offer->products()->sync($productIds);
        }
    }
}

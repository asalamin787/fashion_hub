<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $coupons = [
            [
                'name' => 'Welcome Discount',
                'code' => 'WELCOME10',
                'type' => 'percentage',
                'value' => 10,
                'min_order_amount' => 1000,
                'max_discount_amount' => 500,
                'usage_limit' => 500,
                'used_count' => 42,
                'is_active' => true,
                'starts_at' => $now->copy()->subDays(7),
                'expires_at' => $now->copy()->addMonths(2),
            ],
            [
                'name' => 'Flat Save 300',
                'code' => 'SAVE300',
                'type' => 'fixed',
                'value' => 300,
                'min_order_amount' => 2000,
                'max_discount_amount' => null,
                'usage_limit' => 250,
                'used_count' => 18,
                'is_active' => true,
                'starts_at' => $now->copy()->subDays(3),
                'expires_at' => $now->copy()->addMonths(1),
            ],
            [
                'name' => 'Premium Cart Offer',
                'code' => 'PREMIUM15',
                'type' => 'percentage',
                'value' => 15,
                'min_order_amount' => 5000,
                'max_discount_amount' => 1200,
                'usage_limit' => 100,
                'used_count' => 7,
                'is_active' => true,
                'starts_at' => $now->copy()->subDay(),
                'expires_at' => $now->copy()->addWeeks(3),
            ],
            [
                'name' => 'Flash Preview',
                'code' => 'FLASH25',
                'type' => 'percentage',
                'value' => 25,
                'min_order_amount' => 3000,
                'max_discount_amount' => 1000,
                'usage_limit' => 50,
                'used_count' => 0,
                'is_active' => false,
                'starts_at' => $now->copy()->addDays(2),
                'expires_at' => $now->copy()->addDays(10),
            ],
        ];

        foreach ($coupons as $couponData) {
            Coupon::query()->updateOrCreate(
                ['code' => $couponData['code']],
                $couponData,
            );
        }
    }
}

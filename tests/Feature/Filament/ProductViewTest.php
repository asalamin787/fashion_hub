<?php

use App\Filament\Resources\Products\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('admin can view a product with json variants in filament', function () {
    $admin = User::factory()->admin()->create();

    $product = Product::create([
        'name' => 'Classic Crew Tee',
        'slug' => 'classic-crew-tee',
        'status' => 'active',
        'has_variants' => true,
        'attributes' => [
            [
                'name' => 'Size',
                'slug' => 'size',
                'display_type' => 'text',
                'values' => [
                    ['label' => 'Small', 'value' => 's'],
                ],
            ],
        ],
        'variants' => [
            [
                'id' => 'variant-1',
                'sku' => 'CLASSIC-CREW-TEE-S',
                'barcode' => null,
                'attributes' => [
                    'size' => 's',
                ],
                'attribute_labels' => [
                    'size' => 'Small',
                ],
                'price' => 1200,
                'sale_price' => 999,
                'sale_start_at' => null,
                'sale_end_at' => null,
                'stock' => 10,
                'low_stock_alert' => 2,
                'image' => null,
                'is_default' => true,
                'status' => 'active',
            ],
        ],
    ]);

    $response = $this
        ->actingAs($admin)
        ->get(ProductResource::getUrl('view', ['record' => $product]));

    $response
        ->assertSuccessful()
        ->assertSee('Classic Crew Tee')
        ->assertSee('Size: Small');
});

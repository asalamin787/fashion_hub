<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('product_variant_id')->nullable();
            $table->unsignedInteger('quantity');

            // Snapshot fields captured at the time the item is added
            $table->string('product_name');
            $table->string('variant_label')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();

            $table->timestamps();

            // One row per product+variant combination per cart
            $table->unique(['cart_id', 'product_id', 'product_variant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};

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
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'first_order_discount_applied')) {
                $table->boolean('first_order_discount_applied')->default(false)->after('coupon_code');
            }

            if (! Schema::hasColumn('orders', 'first_order_discount_rate')) {
                $table->decimal('first_order_discount_rate', 5, 2)->nullable()->after('first_order_discount_applied');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = [];

            foreach (['first_order_discount_applied', 'first_order_discount_rate'] as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $columns[] = $column;
                }
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};

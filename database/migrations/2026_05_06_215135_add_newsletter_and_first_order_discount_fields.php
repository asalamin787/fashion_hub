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
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'is_subscribed')) {
                $table->boolean('is_subscribed')->default(false)->after('is_active');
            }

            if (! Schema::hasColumn('users', 'subscribed_at')) {
                $table->timestamp('subscribed_at')->nullable()->after('is_subscribed');
            }

            if (! Schema::hasColumn('users', 'first_order_discount_available')) {
                $table->boolean('first_order_discount_available')->default(false)->after('subscribed_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [];

            foreach (['is_subscribed', 'subscribed_at', 'first_order_discount_available'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $columns[] = $column;
                }
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};

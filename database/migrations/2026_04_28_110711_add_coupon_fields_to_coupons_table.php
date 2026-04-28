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
        if (! Schema::hasColumn('coupons', 'name')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->string('name')->after('id');
            });
        }

        if (! Schema::hasColumn('coupons', 'code')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->string('code')->unique()->after('name');
            });
        }

        if (! Schema::hasColumn('coupons', 'type')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->enum('type', ['percentage', 'fixed'])->default('percentage')->index()->after('code');
            });
        }

        if (! Schema::hasColumn('coupons', 'value')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->decimal('value', 10, 2)->after('type');
            });
        }

        if (! Schema::hasColumn('coupons', 'min_order_amount')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->decimal('min_order_amount', 10, 2)->nullable()->after('value');
            });
        }

        if (! Schema::hasColumn('coupons', 'max_discount_amount')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->decimal('max_discount_amount', 10, 2)->nullable()->after('min_order_amount');
            });
        }

        if (! Schema::hasColumn('coupons', 'usage_limit')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->unsignedInteger('usage_limit')->nullable()->after('max_discount_amount');
            });
        }

        if (! Schema::hasColumn('coupons', 'used_count')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->unsignedInteger('used_count')->default(0)->after('usage_limit');
            });
        }

        if (! Schema::hasColumn('coupons', 'is_active')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->index()->after('used_count');
            });
        }

        if (! Schema::hasColumn('coupons', 'starts_at')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->timestamp('starts_at')->nullable()->index()->after('is_active');
            });
        }

        if (! Schema::hasColumn('coupons', 'expires_at')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->timestamp('expires_at')->nullable()->index()->after('starts_at');
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropIndex('coupons_is_active_starts_at_expires_at_index');
            $table->dropIndex('coupons_expires_at_index');
            $table->dropIndex('coupons_starts_at_index');
            $table->dropIndex('coupons_is_active_index');
            $table->dropIndex('coupons_type_index');
            $table->dropUnique('coupons_code_unique');
        });

        $columns = [
            'name',
            'code',
            'type',
            'value',
            'min_order_amount',
            'max_discount_amount',
            'usage_limit',
            'used_count',
            'is_active',
            'starts_at',
            'expires_at',
        ];

        $existingColumns = array_values(array_filter(
            $columns,
            fn (string $column): bool => Schema::hasColumn('coupons', $column),
        ));

        if ($existingColumns !== []) {
            Schema::table('coupons', function (Blueprint $table) use ($existingColumns) {
                $table->dropColumn($existingColumns);
            });
        }
    }
};

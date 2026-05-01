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
            $table->string('stripe_payment_intent_id', 191)
                ->nullable()
                ->after('transaction_id');

            $table->index('stripe_payment_intent_id');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_intent_id', 191)
                ->nullable()
                ->after('transaction_id');

            $table->timestamp('updated_at')
                ->nullable()
                ->after('created_at');

            $table->index('payment_intent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['stripe_payment_intent_id']);
            $table->dropColumn('stripe_payment_intent_id');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['payment_intent_id']);
            $table->dropColumn(['payment_intent_id', 'updated_at']);
        });
    }
};

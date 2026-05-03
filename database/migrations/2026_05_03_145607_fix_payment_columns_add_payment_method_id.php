<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Widen orders columns and add payment_method_id
        Schema::table('orders', function (Blueprint $table) {
            $table->string('transaction_id', 255)->nullable()->change();
            $table->string('stripe_payment_intent_id', 255)->nullable()->change();
            $table->string('payment_method_id', 255)->nullable()->after('stripe_payment_intent_id');
        });

        // Widen payments columns and add payment_method_id
        Schema::table('payments', function (Blueprint $table) {
            $table->string('transaction_id', 255)->nullable()->change();
            $table->string('payment_intent_id', 255)->nullable()->change();
            $table->string('payment_method_id', 255)->nullable()->after('payment_intent_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_method_id');
            $table->string('transaction_id', 191)->nullable()->change();
            $table->string('stripe_payment_intent_id', 191)->nullable()->change();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payment_method_id');
            $table->string('transaction_id', 191)->nullable()->change();
            $table->string('payment_intent_id', 191)->nullable()->change();
        });
    }
};

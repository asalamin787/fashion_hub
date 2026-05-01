<?php

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_number', 50)->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('cart_id')->nullable()->constrained()->nullOnDelete();

            // Customer snapshot
            $table->string('customer_first_name', 100);
            $table->string('customer_last_name', 100);
            $table->string('customer_email', 191);
            $table->string('customer_phone', 30);
            $table->string('company_name', 150)->nullable();

            // Billing address
            $table->string('country', 2);
            $table->string('street_address', 255);
            $table->string('apartment', 255)->nullable();
            $table->string('city', 120);
            $table->string('state', 120);
            $table->string('zip_code', 20);

            // Optional shipping address
            $table->boolean('shipping_same_as_billing')->default(true);
            $table->string('shipping_first_name', 100)->nullable();
            $table->string('shipping_last_name', 100)->nullable();
            $table->string('shipping_phone', 30)->nullable();
            $table->string('shipping_country', 2)->nullable();
            $table->string('shipping_street_address', 255)->nullable();
            $table->string('shipping_apartment', 255)->nullable();
            $table->string('shipping_city', 120)->nullable();
            $table->string('shipping_state', 120)->nullable();
            $table->string('shipping_zip_code', 20)->nullable();

            $table->text('order_notes')->nullable();

            // Payment snapshot
            $table->string('payment_method', 32)->default(PaymentMethod::CashOnDelivery->value);
            $table->string('payment_status', 32)->default(PaymentStatus::Unpaid->value);
            $table->string('transaction_id', 191)->nullable();
            $table->string('payment_gateway', 64)->nullable();

            // Amounts snapshot
            $table->decimal('subtotal', 12, 2);
            $table->decimal('shipping_amount', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->string('coupon_code', 64)->nullable();
            $table->decimal('total_amount', 12, 2);

            $table->string('order_status', 32)->default(OrderStatus::Pending->value);

            $table->timestamp('placed_at')->useCurrent();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->char('currency', 3)->default('USD');
            $table->decimal('exchange_rate', 12, 6)->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('payment_status');
            $table->index('order_status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

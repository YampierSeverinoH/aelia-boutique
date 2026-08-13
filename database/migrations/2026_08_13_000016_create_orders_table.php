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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('document_type')->default('DNI');
            $table->string('document_number')->nullable();
            $table->string('shipping_address');
            $table->string('region');
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('shipping_agency')->nullable();
            $table->string('reference')->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2);
            $table->string('payment_method')->default('bank_transfer'); // bank_transfer, yape_plin
            $table->string('payment_status')->default('pending'); // pending, paid, verified
            $table->string('order_status')->default('pending'); // pending, processing, shipped, delivered, cancelled
            $table->text('notes')->nullable();
            $table->timestamps();
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

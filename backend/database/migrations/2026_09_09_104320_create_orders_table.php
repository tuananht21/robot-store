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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('customer_name');
            $table->string('phone', 15);
            $table->string('address');
            $table->unsignedBigInteger('total_amount');
            $table->boolean('payment_method')->default(true)->comment('true: Thanh toan khi nhan hang false: Thanh toan online');
            $table->boolean('payment_status')->default(false)->comment('true: Thanh toan thanh cong false: Chua thanh toan / Thanh toan that bai');
            $table->tinyInteger('status')->default(1)->comment('1: pending 2: shipped 3: completed 4: canceled');
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

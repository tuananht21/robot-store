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
        Schema::create('detail_products', function (Blueprint $table) {
            $table->id();
            $table->string('color')->nullable();
            $table->integer('price')->default(0);
            $table->integer('sale_price')->default(0);
            $table->string('version')->nullable();
            $table->foreignId('product_id')->nullable()->constrained('products')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_products');
    }
};

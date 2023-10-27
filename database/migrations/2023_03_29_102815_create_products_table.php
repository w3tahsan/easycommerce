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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->string('product_name');
            $table->integer('price');
            $table->integer('discount')->nullable();
            $table->integer('after_discount');
            $table->string('brand')->nullable();
            $table->string('short_desp');
            $table->longText('long_desp');
            $table->longText('additional_info')->nullable();
            $table->string('preview')->nullable();
            $table->string('slug');
            $table->string('sku');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->integer('customer_id');
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('company')->nullable();
            $table->integer('country_id');
            $table->integer('city_id');
            $table->string('address');
            $table->integer('zip')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};

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
        Schema::create('stripeorders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('company')->nullable();
            $table->integer('zip');
            $table->integer('country_id');
            $table->integer('city_id');
            $table->string('notes')->nullable();
            $table->integer('charge');
            $table->integer('discount');
            $table->integer('sub_total');
            $table->integer('customer_id');
            $table->integer('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripeorders');
    }
};

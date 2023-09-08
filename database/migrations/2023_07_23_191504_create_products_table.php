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
            $table->string('uuid');
            $table->integer('category_id');
            $table->integer('currency_id');
            $table->string('name');
            $table->integer('price')->default(0);
            $table->integer('old_price')->default(0);
            $table->string("photo");
            $table->integer('returns')->default(0);
            $table->integer('daily_income')->default(0);
            $table->string('validity');
            $table->string('expired_at')->nullable();
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

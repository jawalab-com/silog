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
            $table->uuid('id')->primary();
            $table->foreignId('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->string('product_name');
            $table->foreignUuid('brand_id')->constrained('brands')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->string('tag')->nullable();
            $table->text('product_description')->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->integer('minimum_quantity')->default(0);
            $table->boolean('verified')->default(false);
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

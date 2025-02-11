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
        Schema::create('rfq_supplier_products', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('rfq_supplier_id')->constrained('rfq_suppliers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('product_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('quantity');
            $table->integer('quantity_verified')->nullable();
            $table->foreignId('unit_id')->nullable()->constrained('units')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('estimation_price', 10, 2)->default(0);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('total_estimation_price', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfq_supplier_products');
    }
};

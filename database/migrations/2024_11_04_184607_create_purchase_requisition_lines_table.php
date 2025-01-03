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
        Schema::create('purchase_requisition_lines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('purchase_requisition_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('product_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('unit_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('quantity', 10, 2);
            $table->decimal('price_unit', 10, 2)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisition_lines');
    }
};

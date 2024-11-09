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
        Schema::create('rfq_suppliers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('rfq_id')->constrained('rfqs')->onDelete('cascade')->onUpdate('cascade');
            $table->string('tag');
            $table->foreignUuid('supplier_id');
            $table->string('po_number')->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('tax', 10, 2)->nullable();
            $table->decimal('transportation', 10, 2)->nullable();
            $table->string('file_proof')->nullable();
            $table->string('file_invoice')->nullable();
            $table->string('file_receipt')->nullable();
            $table->datetime('date_sent')->nullable();
            $table->datetime('date_received')->nullable();
            $table->boolean('sent')->default(false);
            $table->boolean('received')->default(false);
            $table->boolean('paid')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfq_suppliers');
    }
};

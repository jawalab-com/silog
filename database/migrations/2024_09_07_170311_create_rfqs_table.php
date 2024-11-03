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
        Schema::create('rfqs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('rfq_number')->unique();
            $table->date('request_date');
            $table->date('allocation_date')->nullable();
            $table->string('title')->nullable();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->boolean('verified_1')->nullable();
            $table->boolean('verified_2')->nullable();
            $table->boolean('verified_3')->nullable();
            $table->boolean('verified_4')->nullable();
            $table->boolean('payment_status')->default(false);
            $table->string('status');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfqs');
    }
};

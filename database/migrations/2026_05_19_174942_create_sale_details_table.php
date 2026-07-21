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
        Schema::create('sale_details', function ($table) {
    $table->id(); $table->integer('sale_id'); $table->integer('product_id'); $table->date('date'); $table->integer('quantity'); $table->decimal('cost_price', 10, 2); $table->decimal('sale_price', 10, 2); $table->decimal('sub_amount', 10, 2); $table->unsignedBigInteger('shippment_id')->nullable()->change(); $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};

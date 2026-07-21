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
       Schema::create('stocks', function ($table) {
    $table->id(); $table->integer('quantity'); $table->integer('unit_price'); $table->integer('purchase_id')->nullable(); $table->integer('purchasedetail_id')->nullable(); $table->integer('product_id'); $table->date('date'); $table->integer('updated_stock'); $table->integer('supplier_id')->nullable(); $table->integer('customer_id')->nullable(); $table->string('process'); $table->integer('sale_id')->nullable(); $table->integer('saledetail_id')->nullable(); $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};

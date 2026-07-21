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
    Schema::create('tbl_chart_of_accounts', function (Blueprint $table) {
        $table->id();
        $table->string('head_code');
        $table->string('head_name');
        $table->integer('parent_id')->nullable();
        $table->integer('level');
        $table->integer('supplier_id')->nullable();
        $table->integer('customer_id')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_chart_of_accounts');
    }
};

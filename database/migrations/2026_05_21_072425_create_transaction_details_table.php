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
    Schema::create('transaction_details', function (Blueprint $table) {
        $table->id();
        $table->date('date');
        $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
        $table->string('head_code');
         $table->string('narration')->nullable();
        $table->decimal('debit', 10, 2)->default(0);
        $table->decimal('credit', 10, 2)->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};

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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->unique();
            $table->string('service_name');
            $table->decimal('total_price', 15, 2);
            $table->string('discount_code')->nullable();
            $table->string('address');
            $table->string('phone');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('bank_id');
            $table->enum('status', ['finished', 'paid', 'waiting payment', 'rejected'])->default('waiting payment');
            $table->string('proof')->nullable();
            $table->timestamps();
        
            $table->foreign('bank_id')->references('id')->on('bank_accounts')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_service')->nullable()->index('invoices_id_service_foreign');
            $table->string('affiliate_code')->nullable();
            $table->unsignedBigInteger('id_buyer')->nullable()->index('invoices_id_buyer_foreign');
            $table->string('invoice_id')->unique();
            $table->string('service_name');
            $table->decimal('total_price', 15);
            $table->string('discount_code')->nullable();
            $table->text('address');
            $table->string('phone');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('bank_id')->index('invoices_bank_id_foreign');
            $table->enum('status', ['finished', 'paid', 'waiting payment', 'expired', 'rejected'])->nullable()->default('waiting payment');
            $table->string('proof')->nullable();
            $table->timestamps();
            $table->enum('project_status', ['finished', 'reviewing', 'wip', 'waiting installer'])->default('waiting installer');
            $table->unsignedTinyInteger('progress_percentage')->default(0);
            $table->text('log')->nullable();
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

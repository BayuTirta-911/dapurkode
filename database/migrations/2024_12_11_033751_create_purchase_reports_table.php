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
        Schema::create('purchase_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('purchase_code')->unique();
            $table->unsignedBigInteger('user_id')->nullable()->index('purchase_reports_user_id_foreign');
            $table->unsignedBigInteger('service_id')->index('purchase_reports_service_id_foreign');
            $table->decimal('total_price', 10);
            $table->unsignedBigInteger('bank_id')->index('purchase_reports_bank_id_foreign');
            $table->text('order_address');
            $table->string('backup_phone');
            $table->text('installer_note')->nullable();
            $table->string('discount_code')->nullable();
            $table->decimal('discount_amount', 10)->default(0);
            $table->enum('payment_status', ['finished', 'paid', 'pending payment', 'expired', 'rejected'])->default('pending payment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_reports');
    }
};

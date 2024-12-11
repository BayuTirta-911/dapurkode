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
            $table->id();
            $table->string('purchase_code')->unique(); // Kode unik
            $table->unsignedBigInteger('user_id')->nullable(); // Relasi ke user
            $table->unsignedBigInteger('service_id'); // Relasi ke service
            $table->decimal('total_price', 10, 2); // Total harga
            $table->unsignedBigInteger('bank_id'); // Bank yang dipilih
            $table->text('order_address'); // Alamat pemesanan
            $table->string('backup_phone'); // Nomor telepon cadangan
            $table->text('installer_note')->nullable(); // Catatan untuk installer
            $table->string('discount_code')->nullable(); // Kode diskon jika ada
            $table->decimal('discount_amount', 10, 2)->default(0); // Jumlah diskon
            $table->enum('payment_status', ['finished', 'paid', 'pending payment', 'expired', 'rejected'])->default('pending payment'); // Status pembayaran
            $table->timestamps();

            // Relasi
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('bank_id')->references('id')->on('bank_accounts')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_reports');
    }
};

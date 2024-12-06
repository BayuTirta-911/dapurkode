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
        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'discount_code')) {
                // Tambahkan kolom jika belum ada
                $table->unsignedBigInteger('discount_code')->nullable()->after('total_price');
                
                // Tambahkan foreign key
                $table->foreign('discount_code')->references('id')->on('discounts')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Hapus foreign key dan kolom
            if (Schema::hasColumn('invoices', 'discount_code')) {
                $table->dropForeign(['discount_code']);
                $table->dropColumn('discount_code');
            }
        });
    }
};

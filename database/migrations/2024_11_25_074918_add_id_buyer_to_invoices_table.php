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
            // Tambahkan kolom id_buyer
            $table->unsignedBigInteger('id_buyer')->nullable()->after('id'); // Kolom id_buyer
            
            // Relasi ke tabel users
            $table->foreign('id_buyer')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Hapus foreign key dan kolom id_buyer
            $table->dropForeign(['id_buyer']);
            $table->dropColumn('id_buyer');
        });
    }
};

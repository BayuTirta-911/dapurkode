<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Menambahkan kolom id_service
            $table->unsignedBigInteger('id_service')->nullable()->after('id');

            // Menambahkan relasi ke tabel services
            $table->foreign('id_service')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Menghapus relasi dan kolom id_service
            $table->dropForeign(['id_service']);
            $table->dropColumn('id_service');
        });
    }
};

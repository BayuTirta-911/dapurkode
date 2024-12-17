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
            $table->decimal('og_price', 15, 2)->nullable()->after('total_price'); // Kolom harga original
            $table->decimal('og_disc', 15, 2)->nullable()->after('og_price'); // Kolom diskon original
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['og_price', 'og_disc']);
        });
    }
};

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
            $table->foreign(['bank_id'])->references(['id'])->on('bank_accounts')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['id_buyer'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['id_service'])->references(['id'])->on('services')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('invoices_bank_id_foreign');
            $table->dropForeign('invoices_id_buyer_foreign');
            $table->dropForeign('invoices_id_service_foreign');
        });
    }
};

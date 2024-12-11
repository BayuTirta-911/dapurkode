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
        Schema::table('purchase_reports', function (Blueprint $table) {
            $table->foreign(['bank_id'])->references(['id'])->on('bank_accounts')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['service_id'])->references(['id'])->on('services')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_reports', function (Blueprint $table) {
            $table->dropForeign('purchase_reports_bank_id_foreign');
            $table->dropForeign('purchase_reports_service_id_foreign');
            $table->dropForeign('purchase_reports_user_id_foreign');
        });
    }
};

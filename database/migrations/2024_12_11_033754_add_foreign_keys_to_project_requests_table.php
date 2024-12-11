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
        Schema::table('project_requests', function (Blueprint $table) {
            $table->foreign(['installer_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['invoice_id'])->references(['id'])->on('invoices')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_requests', function (Blueprint $table) {
            $table->dropForeign('project_requests_installer_id_foreign');
            $table->dropForeign('project_requests_invoice_id_foreign');
        });
    }
};

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
        DB::statement("ALTER TABLE invoices MODIFY COLUMN status ENUM('finished', 'paid', 'waiting payment', 'expired', 'rejected') DEFAULT 'waiting payment'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE invoices MODIFY COLUMN status ENUM('finished', 'paid', 'waiting payment', 'expired', 'rejected') DEFAULT 'waiting payment'");
    }
};
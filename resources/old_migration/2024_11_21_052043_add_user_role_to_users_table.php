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
        Schema::table('users', function (Blueprint $table) {
            // Pastikan kolom role sudah ada, jika belum tambahkan default 'user'
            $table->enum('role', ['admin', 'vendor', 'installer', 'affiliator', 'user'])->default('user')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kembalikan ke enum lama tanpa 'user'
            $table->enum('role', ['admin', 'vendor', 'installer', 'affiliator'])->default('vendor')->change();
        });
    }
};

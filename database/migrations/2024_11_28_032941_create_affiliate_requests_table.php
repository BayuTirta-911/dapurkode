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
        Schema::create('affiliate_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relasi ke user
            $table->text('self_description'); // Deskripsi diri user
            $table->text('marketing_plan'); // Cara user memasarkan nanti
            $table->string('status')->default('Pending'); // Status request
            $table->text('admin_note')->nullable(); // Catatan admin
            $table->string('affiliate_code')->nullable(); // Kode affiliate
            $table->timestamps();

            // Relasi ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_requests');
    }
};

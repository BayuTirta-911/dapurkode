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
    Schema::create('project_requests', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('installer_id'); // User yang membuat request
        $table->unsignedBigInteger('invoice_id'); // Invoice terkait
        $table->text('reason')->nullable(); // Alasan permintaan
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->text('rejection_reason')->nullable(); // Alasan penolakan admin
        $table->timestamps();

        $table->foreign('installer_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('project_requests');
}

};

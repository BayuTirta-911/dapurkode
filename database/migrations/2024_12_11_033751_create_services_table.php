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
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('services_user_id_foreign');
            $table->unsignedBigInteger('group_id')->nullable()->index('services_group_id_foreign');
            $table->string('name');
            $table->text('description');
            $table->decimal('price_1', 10);
            $table->decimal('price_2', 10)->nullable();
            $table->decimal('price_3', 10)->nullable();
            $table->decimal('installer_fee', 10)->default(0);
            $table->decimal('affiliator_fee', 10)->default(0);
            $table->decimal('other_fee', 10)->default(0);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('image')->nullable();
            $table->text('admin_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};

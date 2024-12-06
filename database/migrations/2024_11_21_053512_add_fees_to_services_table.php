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
        Schema::table('services', function (Blueprint $table) {
            $table->decimal('installer_fee', 10, 2)->default(0)->after('price_3');
            $table->decimal('affiliator_fee', 10, 2)->default(0)->after('installer_fee');
            $table->decimal('other_fee', 10, 2)->default(0)->after('affiliator_fee');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['installer_fee', 'affiliator_fee', 'other_fee']);
        });
    }
};

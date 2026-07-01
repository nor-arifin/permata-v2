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
        Schema::table('profile_clinics', function (Blueprint $table) {
            $table->enum('environment', ['DEV', 'STG', 'PROD'])->default('STG')->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_clinics', function (Blueprint $table) {
            $table->dropColumn('environment');
        });
    }
};

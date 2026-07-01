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
        Schema::table('anamneses', function (Blueprint $table) {
            $table->string('observation_heartrate')->nullable();
            $table->string('observation_respiratory')->nullable();
            $table->string('observation_systolic')->nullable();
            $table->string('observation_diastolic')->nullable();
            $table->string('observation_temperature')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anamneses', function (Blueprint $table) {
            //
        });
    }
};

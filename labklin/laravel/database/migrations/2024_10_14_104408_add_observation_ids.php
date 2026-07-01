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
            $table->string('observation_heartrate_id')->nullable()->after('observation_heartrate');
            $table->string('observation_respiratory_id')->nullable()->after('observation_respiratory');
            $table->string('observation_systolic_id')->nullable()->after('observation_systolic');
            $table->string('observation_diastolic_id')->nullable()->after('observation_diastolic');
            $table->string('observation_temperature_id')->nullable()->after('observation_temperature');
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

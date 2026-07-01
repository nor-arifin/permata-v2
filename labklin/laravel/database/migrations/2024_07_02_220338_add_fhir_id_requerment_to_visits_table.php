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
        Schema::table('visits', function (Blueprint $table) {
            $table->string('visit_diagnosticreport_id')->nullable()->after('visit_encounter_id');
            $table->string('visit_specimen_id')->nullable()->after('visit_encounter_id');
            $table->string('visit_servicerequest_id')->nullable()->after('visit_encounter_id');
            $table->string('visit_observation_id')->nullable()->after('visit_encounter_id');
            $table->string('visit_condition_id')->nullable()->after('visit_encounter_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            //
        });
    }
};

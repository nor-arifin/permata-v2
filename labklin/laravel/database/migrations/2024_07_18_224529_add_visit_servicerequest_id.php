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
        Schema::table('services_detail', function (Blueprint $table) {
            $table->string('service_diagnosticreport_id')->nullable()->after('service_visit_encounter_id');
            $table->string('service_specimen_id')->nullable()->after('service_visit_encounter_id');
            $table->string('service_servicerequest_id')->nullable()->after('service_visit_encounter_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services_detail', function (Blueprint $table) {
            //
        });
    }
};

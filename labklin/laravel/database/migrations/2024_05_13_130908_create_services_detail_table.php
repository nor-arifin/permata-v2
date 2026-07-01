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
        Schema::create('services_detail', function (Blueprint $table) {
            $table->id();
            $table->string('service_visit_registration_id');
            $table->string('service_visit_encounter_id')->nullable();
            $table->string('service_visit_encoded');
            $table->string('service_visit_patient_mr');
            $table->string('service_loinc_code')->nullable();
            $table->string('service_loinc_display')->nullable();
            $table->string('service_code')->nullable();
            $table->string('service_name')->nullable();
            $table->string('service_group')->nullable();
            $table->string('service_subgroup')->nullable();
            $table->string('service_result')->nullable();
            $table->string('service_price')->nullable();
            $table->string('service_quantity')->nullable();
            $table->string('service_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_detail');
    }
};

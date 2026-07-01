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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('visit_registration_id')->unique();
            $table->string('visit_patient_name');
            $table->string('visit_patient_mr');
            $table->string('visit_patient_ihs');
            $table->string('visit_patient_telecom')->nullable();
            $table->string('visit_patient_dept')->nullable();
            $table->enum('visit_method', ['RAJAL', 'IGD', 'RANAP', 'HOMECARE', 'TELEKONSULTASI'])->default('RAJAL');
            $table->string('visit_doctor_id')->nullable();
            $table->string('visit_location_id')->nullable();
            $table->enum('visit_status_timeline', ['Registered', 'Arrived', 'Waiting', 'Sampling', 'Examination', 'Validation', 'Reporting', 'Finished'])->default('Registered');
            //Registered
            $table->string('visit_registered_by')->nullable();
            //Sampling
            $table->string('visit_time_sampling')->nullable();
            $table->string('visit_sampling_by')->nullable();
            //Examination
            $table->string('visit_time_hematology')->nullable();
            $table->string('visit_time_clinicalchemistry')->nullable();
            $table->string('visit_time_immunology')->nullable();
            $table->string('visit_time_microbiology')->nullable();
            $table->string('visit_time_virology')->nullable();
            $table->string('visit_time_other')->nullable();
            //Validation
            $table->string('visit_time_validation')->nullable();
            $table->string('visit_validation_impression')->nullable();
            $table->string('visit_validation_by')->nullable();
            //Payment
            $table->string('visit_payment_charge')->nullable();
            $table->string('visit_payment_discount')->nullable();
            $table->string('visit_payment_voucher')->nullable();
            $table->string('visit_payment_method')->nullable();
            $table->string('visit_payment_amount')->nullable();
            $table->string('visit_payment_remaining')->nullable();
            $table->string('visit_payment_time')->nullable();
            $table->string('visit_payment_officer')->nullable();
            //Condition
            $table->string('visit_icd10_code')->nullable();
            $table->string('visit_icd10_display')->nullable();
            $table->string('visit_category')->nullable();
            $table->enum('visit_clinical_status', ['active', 'inactive', 'resolved'])->default('active');
            $table->timestamp('visit_date_arrived');
            $table->timestamp('visit_date_progress')->nullable();
            $table->timestamp('visit_date_finished')->nullable();
            $table->timestamp('visit_condition_onset')->nullable();
            $table->timestamp('visit_condition_recorded')->nullable();
            $table->string('visit_encounter_id')->nullable();
            $table->string('visit_encoded')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};

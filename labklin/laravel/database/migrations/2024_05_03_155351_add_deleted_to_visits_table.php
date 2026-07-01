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
            $table->string('visit_condition_recorded')->after('visit_clinical_status')->nullable();
            $table->string('visit_condition_onset')->after('visit_clinical_status')->nullable();
            $table->string('visit_date_finished')->after('visit_clinical_status')->nullable();
            $table->string('visit_date_progress')->after('visit_clinical_status')->nullable();
            $table->string('visit_date_arrived')->after('visit_clinical_status')->nullable();
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

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
        Schema::create('anamneses', function (Blueprint $table) {
            $table->id();
            $table->string('visit_encounter_id');
            $table->string('visit_registration_id')->unique();
            $table->string('condition_clinicalstatus');
            $table->string('condition_category');
            $table->string('condition_code');
            $table->string('condition_display');
            $table->string('condition_subject');
            $table->string('condition_onset');
            $table->string('condition_recorded');
            $table->string('condition_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anamneses');
    }
};

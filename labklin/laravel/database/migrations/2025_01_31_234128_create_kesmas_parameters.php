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
        Schema::create('kesmas_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('parameter_code')->unique();
            $table->string('parameter_name');
            $table->string('parameter_method');
            $table->string('parameter_unit');
            $table->string('parameter_category');
            $table->string('parameter_group');
            $table->string('parameter_subgroup');
            $table->string('parameter_specimen');
            $table->string('parameter_specimen_group');
            $table->string('parameter_parent');
            $table->string('parameter_reference_type');
            $table->string('parameter_reference_min');
            $table->string('parameter_reference_max');
            $table->string('parameter_reference_value');
            $table->integer('parameter_price');
            $table->string('parameter_acreditation');
            $table->string('parameter_time');
            $table->string('parameter_status');
            $table->string('parameter_description');
            $table->string('parameter_encode')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kesmas_parameters');
    }
};

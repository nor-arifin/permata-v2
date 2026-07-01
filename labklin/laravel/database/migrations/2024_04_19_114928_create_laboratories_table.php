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
        Schema::create('laboratories', function (Blueprint $table) {
            $table->id();
            $table->string('test_loinc_code');
            $table->string('test_loinc_display');
            $table->string('test_code')->unique();
            $table->string('test_name');
            $table->string('test_unit')->nullable();
            $table->string('test_method')->nullable();
            $table->string('test_specimen');
            $table->string('test_resulttype');
            $table->string('test_normal_general')->nullable();
            $table->string('test_min_general')->nullable();
            $table->string('test_max_general')->nullable();
            $table->string('test_normal_male')->nullable();
            $table->string('test_min_male')->nullable();
            $table->string('test_max_male')->nullable();
            $table->string('test_normal_female')->nullable();
            $table->string('test_min_female')->nullable();
            $table->string('test_max_female')->nullable();
            $table->string('test_normal_baby')->nullable();
            $table->string('test_min_baby')->nullable();
            $table->string('test_max_baby')->nullable();
            $table->string('test_normal_child')->nullable();
            $table->string('test_min_child')->nullable();
            $table->string('test_max_child')->nullable();
            $table->string('test_group');
            $table->string('test_subgroup');
            $table->string('test_category');
            $table->string('test_partof')->nullable();
            $table->enum('test_active', ['active', 'inactive'])->default('active');
            $table->string('test_price')->nullable();
            $table->string('test_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratories');
    }
};

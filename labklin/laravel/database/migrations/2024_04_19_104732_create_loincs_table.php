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
        Schema::create('loincs', function (Blueprint $table) {
            $table->id();
            $table->string('loinc_code'); //loinc code
            $table->string('loinc_display'); //loinc display common name
            $table->string('loinc_component')->nullable(); //loinc component/analyte
            $table->string('loinc_property')->nullable(); //Property merupakan atribut atau karakteristik yang dapat diukur dari component/analyte
            $table->string('loinc_system')->nullable(); //loinc system/specimen
            $table->string('loinc_scale')->nullable(); //loinc result type
            $table->string('loinc_method')->nullable(); //loinc method
            $table->string('loinc_unitofmeasure')->nullable(); //loinc unit
            $table->string('loinc_codesystem')->nullable(); //loinc code system link
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loincs');
    }
};

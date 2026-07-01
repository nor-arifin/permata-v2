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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            //medical record
            $table->string('patient_mr')->unique();
            //patient ihs code
            $table->string('patient_ihs')->unique();
            //idintifier
            $table->enum('patient_identifier', ['nik','paspor','kk','nik-ibu']);
            //patient nik
            $table->string('patient_nik')->unique();
            //patient kk
            $table->string('patient_kk')->nullable();
            //patient name
            $table->string('patient_name');
            //patient gender
            $table->enum('patient_gender', ['male', 'female']);
            //patient birthplace
            $table->string('patient_birthplace');
            //patient birthdate
            $table->date('patient_birthdate');
            //patient phone
            $table->string('patient_telecom')->nullable();
            //patient email
            $table->string('patient_email')->nullable();
            // patient address
            $table->string('patient_address_use')->default('home');
            $table->string('patient_address_line');
            $table->string('patient_address_city');
            $table->string('patient_address_country')->default('ID');
            $table->string('patient_address_postalcode')->nullable();
            $table->string('patient_address_extension')->nullable();
            //patient address extention
            $table->string('patient_code_province')->nullable();
            $table->string('patient_code_city')->nullable();
            $table->string('patient_code_district')->nullable();
            $table->string('patient_code_village')->nullable();
            $table->string('patient_code_rt')->nullable();
            $table->string('patient_code_rw')->nullable();
            //patient maritalstatus
            $table->enum('patient_marital_status', ['S', 'M', 'W', 'D']);
            //relationship
            $table->string('patient_relationship_name')->nullable();
            $table->string('patient_relationship_phone')->nullable();
            //citizenshipstatus
            $table->enum('patient_citizenship_status', ['WNI', 'WNA', 'WNI-ASING'])->default('WNI');
            //deceaded boolean
            $table->enum('patient_deceased', ['true', 'false'])->default('false');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};

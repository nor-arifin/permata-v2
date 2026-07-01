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
        Schema::table('profile_clinics', function (Blueprint $table) {
            $table->string('organization_id')->nullable();
            $table->string('client_id')->nullable();
            $table->string('client_secretkey')->nullable();
            $table->string('base_address_longitude')->nullable();
            $table->string('base_address_latitude')->nullable();
            $table->string('base_address_altitude')->nullable();
            //address
            $table->string('base_address_use')->default('work');
            $table->string('base_address_line')->nullable();
            $table->string('base_address_city')->nullable();
            $table->string('base_address_country')->default('ID');
            $table->string('base_address_postalcode')->nullable();
            $table->string('base_address_extension')->nullable();
            //address extention
            $table->string('base_code_province')->nullable();
            $table->string('base_code_city')->nullable();
            $table->string('base_code_district')->nullable();
            $table->string('base_code_village')->nullable();
            $table->string('base_code_rt')->nullable();
            $table->string('base_code_rw')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            //
        });
    }
};

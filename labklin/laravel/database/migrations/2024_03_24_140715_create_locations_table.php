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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('location_code');
            $table->string('location_name');
            $table->string('location_uuid')->nullable();
            $table->enum('location_physical_type', ['ro', 'bu', 'wi', 've','ho','ca', 'rd', 'area'])->default('ro');// ro = ruangan, bu = bangunan, wi = sayap gedung, ve = kendaraan, ho = rumah, ca = kabined, rd = jalan, area = area. Default bila tidak dideklarasikan = ruangan
            //status
            $table->enum('location_status', ['active','suspended', 'inactive'])->default('active');
            //description
            $table->string('location_description')->nullable();
            //mode
            $table->enum('location_mode', ['instance', 'kind'])->default('instance');
            //telecom
            $table->string('location_telecom')->nullable();
            //email
            $table->string('location_email')->nullable();
            //position
            $table->string('location_position_longitude')->nullable();
            $table->string('location_position_latitude')->nullable();
            $table->string('location_position_altitude')->nullable();
            //address
            $table->string('location_address_use')->default('work');
            $table->string('location_address_line');
            $table->string('location_address_city');
            $table->string('location_address_country')->default('ID');
            $table->string('location_address_postalcode')->nullable();
            $table->string('location_address_extension')->nullable();
            //address extention
            $table->string('location_code_province')->nullable();
            $table->string('location_code_city')->nullable();
            $table->string('location_code_district')->nullable();
            $table->string('location_code_village')->nullable();
            $table->string('location_code_rt')->nullable();
            $table->string('location_code_rw')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};

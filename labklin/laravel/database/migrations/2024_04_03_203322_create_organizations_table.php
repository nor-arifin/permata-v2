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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('organization_uuid')->nullable();
            $table->string('organization_code');
            $table->string('organization_name');
            //type
            $table->enum('organization_type', ['prov', 'laboratory', 'dept', 'team', 'govt', 'ins', 'pay', 'edu', 'reli', 'crs', 'cg', 'bus', 'other'])->default('prov');//prov = Healthcare Provider, dept = Hospital Department, team = Organizational team, govt = Government, ins = Insurance Company, pay = Payer, edu = Educational Institute, reli = Religious Institution, crs = Clinical Research Sponsor, cg = Community Group, bus = Business, other = Lainnya
            //telecom
            $table->string('organization_telecom')->nullable();
            //email
            $table->string('organization_email')->nullable();
            //status
            $table->enum('organization_status', ['active','suspended', 'inactive'])->default('active');
            //address
            $table->string('organization_address_use')->default('work');
            $table->string('organization_address_line')->nullable();
            $table->string('organization_address_city')->nullable();
            $table->string('organization_address_country')->default('ID');
            $table->string('organization_address_postalcode')->nullable();
            //address extention
            $table->string('organization_code_province')->nullable();
            $table->string('organization_code_city')->nullable();
            $table->string('organization_code_district')->nullable();
            $table->string('organization_code_village')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};

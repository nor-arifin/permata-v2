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
        Schema::table('patients', function (Blueprint $table) {
            $table->string('patient_profession')->after('patient_status')->nullable();
            $table->enum('patient_bloodtype', ['A', 'B', 'AB', 'O','-'])->after('patient_marital_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['patient_profession', 'patient_bloodtype']);
        });
    }
};

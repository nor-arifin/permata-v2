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
        Schema::table('kesmas_parameters', function (Blueprint $table) {
            $table->string('parameter_container')->after('parameter_specimen_group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kesmas_parameters', function (Blueprint $table) {
            $table->dropColumn('parameter_container');
        });
    }
};

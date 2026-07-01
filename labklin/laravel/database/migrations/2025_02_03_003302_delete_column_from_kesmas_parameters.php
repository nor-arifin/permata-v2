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
            $table->dropColumn('parameter_specimen_group');
            $table->dropColumn('parameter_reference_min');
            $table->dropColumn('parameter_reference_max');
            //Modify the column to be nullable
            $table->string('parameter_parent')->nullable()->change();
            $table->string('parameter_description')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kesmas_parameters', function (Blueprint $table) {
            $table->string('parameter_specimen_group');
            $table->string('parameter_reference_min');
            $table->string('parameter_reference_max');
            //Modify the column to be nullable
            $table->string('parameter_parent')->nullable(false)->change();
            $table->string('parameter_description')->nullable(false)->change();
        });
    }
};

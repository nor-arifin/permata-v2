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
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn('visit_date_arrived');
            $table->dropColumn('visit_date_progress');
            $table->dropColumn('visit_date_finished');
            $table->dropColumn('visit_condition_onset');
            $table->dropColumn('visit_condition_recorded');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            //
        });
    }
};

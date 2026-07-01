<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kesmas_order_samples', function (Blueprint $table) {
            $table->integer('sample_charge')->default(0)->after('sample_description');
            $table->dropColumn('sample_condition');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kesmas_order_samples', function (Blueprint $table) {
            $table->dropColumn('sample_charge');
            $table->string('sample_condition')->nullable()->after('sample_description');
        });
    }
};
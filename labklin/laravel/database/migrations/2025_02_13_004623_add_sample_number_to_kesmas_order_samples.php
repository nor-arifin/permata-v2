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
            $table->string('sample_number')->nullable()->after('sample_type');
            $table->string('sample_division')->nullable()->after('sample_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kesmas_order_samples', function (Blueprint $table) {
            $table->dropColumn('sample_number');
            $table->dropColumn('sample_division');
        });
    }
};
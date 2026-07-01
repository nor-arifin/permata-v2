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
        Schema::table('kesmas_orders_detail', function (Blueprint $table) {
            $table->dropColumn('order_parameter_specimen');
            $table->dropColumn('order_parameter_specimen_group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kesmas_orders_detail', function (Blueprint $table) {
            $table->string('order_parameter_specimen')->nullable();
            $table->string('order_parameter_specimen_group')->nullable();
        });
    }
};
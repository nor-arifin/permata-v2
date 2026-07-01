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
            $table->string('order_parameter_registered')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kesmas_orders_detail', function (Blueprint $table) {
            $table->date('order_parameter_registered')->change();
        });
    }
};
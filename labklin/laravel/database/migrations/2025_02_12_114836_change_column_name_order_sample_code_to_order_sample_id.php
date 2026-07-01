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
            $table->string('order_sample_id')->after('order_sample_code');
            $table->dropColumn('order_sample_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kesmas_orders_detail', function (Blueprint $table) {
            $table->string('order_sample_code')->after('order_sample_id');
            $table->dropColumn('order_sample_id');
        });
    }
};
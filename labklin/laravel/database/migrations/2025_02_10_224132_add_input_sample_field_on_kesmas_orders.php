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
        Schema::table('kesmas_orders', function (Blueprint $table) {
            $table->integer('order_num_sample')->default(0)->after('order_type');
            //order_collector
            $table->string('order_collector')->nullable()->after('order_status');
            //order_sampling_name
            $table->string('order_sampling_name')->nullable()->after('order_collect_user');
            //order_sampling_phone
            $table->string('order_sampling_phone')->nullable()->after('order_sampling_name');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kesmas_orders', function (Blueprint $table) {
            $table->dropColumn('order_num_sample');
            $table->dropColumn('order_collector');
            $table->dropColumn('order_sampling_name');
            $table->dropColumn('order_sampling_phone');
        });
    }
};
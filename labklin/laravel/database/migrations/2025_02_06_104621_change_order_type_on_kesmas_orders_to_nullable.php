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
            $table->string('order_type')->nullable()->change();
            //Make the order_status column default to 'draft'
            $table->string('order_status')->default('draft')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kesmas_orders', function (Blueprint $table) {
            $table->string('order_type')->nullable(false)->change();
            //Make the order_status column not default to 'draft'
            $table->string('order_status')->default(null)->change();
        });
    }
};

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
        Schema::create('kesmas_orders_additional', function (Blueprint $table) {
            $table->id();
            $table->integer('add_order_id');
            $table->string('add_order_code');
            $table->string('add_order_type');
            $table->string('add_order_customer_id');
            $table->string('add_order_task');
            $table->string('add_order_status')->nullable();
            $table->string('add_order_charge');
            $table->string('add_order_result')->nullable();
            $table->string('add_order_handler')->nullable();
            $table->string('add_order_note')->nullable();
            $table->string('add_order_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kesmas_orders_additional');
    }
};
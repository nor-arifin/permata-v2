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
        Schema::create('kesmas_orders_detail', function (Blueprint $table) {
            $table->id();
            $table->string('order_code');
            $table->string('order_parameter_code');
            $table->string('order_parameter_name');
            $table->string('order_parameter_method');
            $table->string('order_parameter_result')->nullable();
            $table->string('order_parameter_flag')->nullable();
            $table->string('order_parameter_unit');
            $table->string('order_parameter_reference_value');
            $table->string('order_parameter_group');
            $table->string('order_parameter_subgroup');
            $table->string('order_parameter_specimen');
            $table->string('order_parameter_specimen_group');
            $table->string('order_parameter_parent');
            $table->integer('order_parameter_price');
            $table->string('order_parameter_acreditation')->nullable();
            $table->string('order_parameter_note')->nullable();
            $table->date('order_parameter_registered')->nullable();
            $table->string('order_parameter_handler')->nullable();
            $table->string('order_parameter_encode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kesmas_orders_detail');
    }
};

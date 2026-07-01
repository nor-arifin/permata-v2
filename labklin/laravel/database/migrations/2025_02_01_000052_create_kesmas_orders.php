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
        Schema::create('kesmas_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->date('order_date');
            $table->string('order_customer');
            $table->string('order_type');
            $table->string('order_status');
            $table->string('order_review')->nullable();
            $table->string('order_review_user')->nullable();
            $table->string('order_collect')->nullable();
            $table->string('order_collect_user')->nullable();
            $table->string('order_receive')->nullable();
            $table->string('order_receive_user')->nullable();
            $table->string('order_process')->nullable();
            $table->string('order_process_user')->nullable();
            $table->string('order_verify')->nullable();
            $table->string('order_verify_user')->nullable();
            $table->string('order_validate')->nullable();
            $table->string('order_validate_user')->nullable();
            $table->string('order_sign')->nullable();
            $table->string('order_sign_user')->nullable();
            $table->string('order_finish')->nullable();
            $table->string('order_finish_user')->nullable();
            $table->string('order_total');
            $table->string('order_user');
            $table->date('order_payment_date')->nullable();
            $table->string('order_payment_method')->nullable();
            $table->string('order_payment_amount')->nullable();
            $table->string('order_payment_user')->nullable();
            $table->string('order_encode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kesmas_orders');
    }
};

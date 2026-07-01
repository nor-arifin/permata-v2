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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->enum('payment_order_type', ['clinic', 'kesmas']);
            $table->string('payment_order_id');
            $table->enum('payment_method', ['Cash', 'Credit Card', 'Debit Card', 'Transfer', 'Virtual Account', 'Qris', 'PKS', 'Insurance', 'BPJS', 'Other']);
            $table->string('payment_bank')->nullable();
            $table->string('payment_card_number')->nullable();
            $table->string('payment_card_cvc')->nullable();
            $table->string('payment_card_holder')->nullable();
            $table->string('payment_card_month')->nullable();
            $table->string('payment_card_year')->nullable();
            $table->string('payment_ref_number')->nullable();
            $table->string('payment_account_name')->nullable();
            $table->string('payment_mou_number')->nullable();
            $table->string('payment_mou_duedate')->nullable();
            $table->string('payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');

    }
};
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
        Schema::create('kesmas_customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_code')->unique();
            $table->string('customer_name');
            $table->string('customer_type');
            $table->string('customer_address');
            $table->string('customer_phone')->unique();
            $table->string('customer_email')->unique();
            $table->string('customer_pic');
            $table->string('customer_pic_phone')->unique();
            $table->string('customer_status');
            $table->string('customer_username')->unique();
            $table->string('customer_password');
            $table->date('customer_registered');
            $table->string('customer_encode')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kesmas_customers');
    }
};

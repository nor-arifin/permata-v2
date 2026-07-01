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
        Schema::table('kesmas_customers', function (Blueprint $table) {
            //set field to not unique
            $table->string('customer_email')->unique(false)->change();
            $table->string('customer_phone', 15)->unique(false)->change();
            $table->string('customer_pic_phone', 15)->unique(false)->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kesmas_customers', function (Blueprint $table) {
            //set field to unique
            $table->string('customer_email')->unique()->change();
            $table->string('customer_phone', 15)->unique()->change();
            $table->string('customer_pic_phone', 15)->unique()->change();
        });
    }
};
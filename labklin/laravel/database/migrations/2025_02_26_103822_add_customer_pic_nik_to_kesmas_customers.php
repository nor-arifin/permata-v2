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
            $table->string('customer_pic_nik', 16)->after('customer_pic_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kesmas_customers', function (Blueprint $table) {
            $table->dropColumn('customer_pic_nik');
        });
    }
};
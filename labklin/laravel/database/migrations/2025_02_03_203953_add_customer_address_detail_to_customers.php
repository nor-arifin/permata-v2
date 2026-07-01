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
            $table->string('customer_address_detail')->after('customer_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kesmas_customers', function (Blueprint $table) {
            $table->dropColumn('customer_address_detail');
        });
    }
};

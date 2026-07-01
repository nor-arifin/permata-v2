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
            $table->string('order_reject')->nullable()->after('order_validate_user');
            //delete order_sign and order_sign_user
            $table->dropColumn('order_sign');
            $table->dropColumn('order_sign_user');
            $table->dropColumn('order_finish');
            $table->dropColumn('order_finish_user');
        });
        //Create Table kesmas_order_rejection
        Schema::create('kesmas_order_rejection', function (Blueprint $table) {
            $table->id();
            $table->string('kesmas_order_id')->nullable();
            $table->string('rejection_reason')->nullable();
            $table->string('rejection_user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kesmas_orders', function (Blueprint $table) {
            $table->dropColumn('order_reject');
            $table->string('order_sign')->nullable()->after('order_validate_user');
            $table->string('order_sign_user')->nullable()->after('order_sign');
            $table->string('order_finish')->nullable()->after('order_sign_user');
            $table->string('order_finish_user')->nullable()->after('order_finish');
        });
        //Drop Table kesmas_order_rejection
        Schema::dropIfExists('kesmas_order_rejection');
    }
};
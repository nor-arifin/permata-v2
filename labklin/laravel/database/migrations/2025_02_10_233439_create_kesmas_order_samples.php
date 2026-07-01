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
        Schema::create('kesmas_order_samples', function (Blueprint $table) {
            $table->id();
            $table->string('order_code');
            $table->string('sample_type');
            $table->string('sample_code');
            $table->string('sample_id');
            $table->string('sample_volume');
            $table->string('sample_container');
            $table->string('sample_description');
            $table->string('sample_condition');
            $table->dateTime('sample_collect_time');
            $table->dateTime('sample_receive_time');
            $table->string('order_encode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kesmas_order_samples');
    }
};
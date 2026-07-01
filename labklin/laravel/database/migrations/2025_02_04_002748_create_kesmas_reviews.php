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
        Schema::create('kesmas_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('review_code')->unique();
            $table->date('review_date');
            $table->string('review_personnel');
            $table->string('review_accomodation');
            $table->string('review_workload');
            $table->string('review_equipment');
            $table->string('review_method');
            $table->string('review_note');
            $table->string('review_conclution');
            $table->string('review_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kesmas_reviews');
    }
};

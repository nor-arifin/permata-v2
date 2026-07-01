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
        Schema::table('kesmas_reviews', function (Blueprint $table) {
            // Add new fields abnormality_expired, abnormality_preservatives, abnormality_outlab, abnormality_outpreservatives, abnormality_other

            $table->string('abnormality_expired')->default('off')->after('review_conclution');
            $table->string('abnormality_preservatives')->default('off')->after('abnormality_expired');
            $table->string('abnormality_outlab')->default('off')->after('abnormality_preservatives');
            $table->string('abnormality_outpreservatives')->default('off')->after('abnormality_outlab');
            $table->string('abnormality_other')->default('off')->after('abnormality_outpreservatives');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kesmas_reviews', function (Blueprint $table) {
            $table->dropColumn('abnormality_expired');
            $table->dropColumn('abnormality_preservatives');
            $table->dropColumn('abnormality_outlab');
            $table->dropColumn('abnormality_outpreservatives');
            $table->dropColumn('abnormality_other');
        });
    }
};
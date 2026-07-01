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
        //loinc_code
        Schema::create('loinc_answers', function (Blueprint $table) {
            $table->id();
            $table->string('loinc_code')->nullable();
            $table->string('loinc_name')->nullable();
            $table->string('answer_list_id')->nullable();
            $table->string('answer_list_name')->nullable();
            $table->string('answer_list_type')->nullable();
            $table->string('answer_id')->nullable();
            $table->string('answer_sequence')->nullable();
            $table->string('answer_display_text')->nullable();
            $table->string('answer_system')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loinc_answers');
    }
};
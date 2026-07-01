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
        Schema::create('register_napza', function (Blueprint $table) {
            $table->id();
            $table->date('letter_napza_date')->nullable();
            $table->string('letter_napza_number')->nullable();
            $table->string('letter_napza_name')->nullable();
            $table->string('letter_napza_mr')->nullable();
            $table->string('letter_napza_lhu')->nullable();
            $table->string('letter_napza_purpose')->nullable();
            $table->string('letter_napza_conclution')->nullable();
            $table->string('letter_napza_signed')->nullable();
            $table->string('letter_napza_encode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_register_napza');
    }
};
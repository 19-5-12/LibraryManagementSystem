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
        Schema::create('TBL_STUDENT', function (Blueprint $table) {
            $table->string('STUDENT_ID')->primary();
            $table->string('LAST_NAME');
            $table->string('FIRST_NAME');
            $table->string('MIDDLE_NAME')->nullable();
            $table->enum('SEX', ['M', 'F']);
            $table->string('ADDRESS');
            $table->string('CONTACT_NUMBER');
            $table->string('EMAIL')->unique();
            $table->time('TIME_IN');
            $table->date('REGISTERED_DATE');
            $table->string('PASSWORD');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('TBL_STUDENT');
    }
}; 
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('exam_time_shedules', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('session_id');
        $table->tinyInteger('class_code');
        $table->unsignedBigInteger('exam_id');
        $table->unsignedBigInteger('subject_id');
        $table->tinyInteger('exam_for')->comment('1.written & MCQ, 2. Practical');
        $table->time('start_time');
        $table->time('end_time');
        $table->date('exam_date');
        $table->timestamps();
        $table->unsignedBigInteger('created_by');
        $table->unsignedBigInteger('updated_by')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_time_shedules');
    }
};

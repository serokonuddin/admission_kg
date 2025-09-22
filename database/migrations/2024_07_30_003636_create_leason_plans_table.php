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
        Schema::create('leason_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('session_id');
            $table->integer('version_id');
            $table->integer('class_id');
            $table->integer('subject_id');
            $table->integer('teacher_id')->nullable();
            $table->date('date');
            $table->tinyInteger('time');
            $table->string('Todays_lesson', 256)->collation('utf8mb4_general_ci');
            $table->string('general_lesson', 256)->collation('utf8mb4_general_ci');
            $table->text('objectives')->collation('utf8mb4_general_ci');
            $table->text('materials')->collation('utf8mb4_general_ci');
            $table->longText('learning_outcomes')->collation('utf8mb4_general_ci');
            $table->string('method', 256)->nullable()->collation('utf8mb4_general_ci');
            $table->longText('details')->collation('utf8mb4_general_ci');
            $table->tinyInteger('status')->comment('1.active, 0.inactive');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leason_plans');
    }
};

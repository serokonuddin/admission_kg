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
        Schema::create('action_takens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issue_id')->constrained('disciplinary_issues')->onDelete('cascade');
            $table->string('action_type');
            $table->text('action_description')->nullable();
            $table->date('action_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_takens');
    }
};

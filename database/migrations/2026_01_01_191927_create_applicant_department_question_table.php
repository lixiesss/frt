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
        Schema::create('applicant_department_question', function (Blueprint $table) {
            $table->uuid('applicant_id');
            $table->uuid('department_question_id');
            $table->timestamps();

            $table->primary(['applicant_id', 'department_question_id'], 'applicant_question_primary');
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
            $table->foreign('department_question_id')->references('id')->on('department_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_department_question');
    }
};

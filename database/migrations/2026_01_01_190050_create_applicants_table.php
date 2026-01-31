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
        Schema::create('applicants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->string('nrp', 20)->unique();
            $table->string('major')->nullable();
            $table->decimal('gpa', 3, 2)->nullable();
            $table->string('gender', 10)->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('value')->nullable();
            $table->string('cv_path')->nullable();
            $table->tinyInteger('stage')->default(0)->comment('0: Registration, 1: Quiz, 2: FGD, 3: Completed');
            $table->boolean('is_draft')->default(true)->comment('true: Draft, false: Final submission');
            
            // First choice department
            $table->string('first_choice_department')->nullable();
            $table->text('first_choice_motivation')->nullable();
            $table->text('first_choice_commitment')->nullable();
            $table->string('first_choice_portfolio_path')->nullable();
            
            // Second choice department
            $table->string('second_choice_department')->nullable();
            $table->text('second_choice_motivation')->nullable();
            $table->text('second_choice_commitment')->nullable();
            $table->string('second_choice_portfolio_path')->nullable();
            
            $table->string('department_answer_path')->nullable();
            $table->uuid('group_id')->nullable();
            $table->boolean('requires_coding_test')->default(false);
            
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('fgd_groups')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};

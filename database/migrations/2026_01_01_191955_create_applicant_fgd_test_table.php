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
        Schema::create('applicant_fgd_test', function (Blueprint $table) {
            $table->uuid('applicant_id');
            $table->uuid('test_id');
            $table->text('answer')->nullable();
            $table->timestamps();

            $table->primary(['applicant_id', 'test_id'], 'applicant_fgd_test_primary');
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
            $table->foreign('test_id')->references('id')->on('fgd_tests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_fgd_test');
    }
};

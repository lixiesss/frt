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
        Schema::create('fgd_tests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('question');
            $table->tinyInteger('type')->comment('0: Pretest, 1: Posttest');
            $table->uuid('topic_id');
            $table->timestamps();

            $table->foreign('topic_id')->references('id')->on('fgd_topics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fgd_tests');
    }
};

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
        Schema::create('fgd_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->dateTime('schedule');
            $table->string('place');
            $table->tinyInteger('category')->comment('0: HAXI, 1: IS & CnB');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fgd_sessions');
    }
};

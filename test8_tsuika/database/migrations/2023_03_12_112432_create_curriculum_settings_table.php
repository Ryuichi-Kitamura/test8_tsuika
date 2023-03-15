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
        Schema::create('curriculum_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('curriculum_id')->unsigned()->nullable();
            $table->foreign('curriculum_id')->references('id')->on('curriculums')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->boolean('is_finished')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curriculum_settings');
    }
};

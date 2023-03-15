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
        Schema::create('exam_answers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('exam_setting_id')->unsigned()->nullable();
            $table->foreign('exam_setting_id')->references('id')->on('exam_settings')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->bigInteger('exam_question_id')->unsigned()->nullable();
            $table->foreign('exam_question_id')->references('id')->on('exam_questions')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->string('answer_text');
            $table->boolean('is_correct')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_answers');
    }
};

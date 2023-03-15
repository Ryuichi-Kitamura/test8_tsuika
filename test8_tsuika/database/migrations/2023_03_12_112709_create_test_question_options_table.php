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
        Schema::create('test_question_options', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('test_question_id')->unsigned()->nullable();
            $table->foreign('test_question_id')->references('id')->on('test_questions')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->integer('option_number');
            $table->string('option_text');
            $table->boolean('is_correct')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_question_options');
    }
};

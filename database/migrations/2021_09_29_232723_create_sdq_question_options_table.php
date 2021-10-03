<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSdqQuestionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sdq_question_options', function (Blueprint $table) {
            $table->id();
            $table->string('option_name')->nullable();
            $table->integer('option_score')->nullable();
            $table->foreignId('sdq_question_id');
            $table->timestamps();
            $table->foreign('sdq_question_id')->references('id')->on('sdq_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sdq_question_options');
    }
}

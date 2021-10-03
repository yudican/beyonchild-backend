<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntelligenceQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intelligence_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_name')->nullable();
            $table->integer('question_score')->nullable();
            $table->foreignId('smart_category_id');
            $table->timestamps();
            $table->foreign('smart_category_id')->references('id')->on('smart_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intelligence_questions');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMentorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentors', function (Blueprint $table) {
            $table->id();
            $table->string('mentor_name')->nullable();
            $table->string('mentor_title')->nullable();
            $table->string('mentor_link_meet')->nullable();
            $table->string('mentor_phone')->nullable();
            $table->string('mentor_email')->nullable();
            $table->integer('mentor_experient')->nullable();
            $table->integer('mentor_benefit')->nullable()->default(1);
            $table->text('mentor_description')->nullable();
            $table->text('mentor_topic_description')->nullable();
            $table->foreignUuid('user_id');
            $table->foreignId('education_level_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('education_level_id')->references('id')->on('education_levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mentors');
    }
}

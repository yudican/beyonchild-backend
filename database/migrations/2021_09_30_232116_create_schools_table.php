<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('school_name')->nullable();
            $table->string('school_image')->nullable();
            $table->text('school_curiculumn')->nullable();
            $table->text('school_description')->nullable();
            $table->integer('school_teacher_count')->nullable();
            $table->foreignId('school_location_id');
            $table->foreignId('education_level_id');
            $table->timestamps();
            $table->foreign('school_location_id')->references('id')->on('school_locations')->onDelete('cascade');
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
        Schema::dropIfExists('schools');
    }
}

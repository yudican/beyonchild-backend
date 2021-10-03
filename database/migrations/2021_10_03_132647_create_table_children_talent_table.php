<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableChildrenTalentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children_talent', function (Blueprint $table) {
            $table->id();
            $table->foreignId('children_id');
            $table->foreignId('interest_talent_id');
            $table->foreign('children_id')->references('id')->on('childrens')->onDelete('cascade');
            $table->foreign('interest_talent_id')->references('id')->on('interest_talent')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('children_talent');
    }
}

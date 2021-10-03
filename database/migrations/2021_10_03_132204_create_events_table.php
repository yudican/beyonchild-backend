<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name')->nullable();
            $table->date('event_date')->nullable();
            $table->integer('event_fee')->nullable();
            $table->string('event_banner')->nullable();
            $table->text('event_description')->nullable();
            $table->text('event_narasumber')->nullable();
            $table->text('event_benefit')->nullable();
            $table->text('event_note')->nullable();
            $table->time('event_start')->nullable();
            $table->time('event_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}

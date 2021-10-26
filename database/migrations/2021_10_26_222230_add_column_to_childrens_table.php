<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToChildrensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('childrens', function (Blueprint $table) {
            $table->integer('children_older')->nullable()->after('children_gender');
            $table->integer('children_order')->nullable()->after('children_older');
            $table->integer('children_school_history')->nullable()->after('children_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('childrens', function (Blueprint $table) {
            $table->dropColumn('children_older');
            $table->dropColumn('children_order');
            $table->dropColumn('children_school_history');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('school_address')->after('school_teacher_count')->nullable();
            $table->string('school_map_address')->after('school_address')->nullable();
            $table->string('school_phone_number')->after('school_map_address')->nullable();
            $table->string('school_email')->after('school_phone_number')->nullable();
            $table->string('school_fee_monthly', 15)->after('school_email')->nullable();
            $table->string('school_accreditation', 15)->after('school_fee_monthly')->nullable();
            $table->string('school_day_start', 15)->after('school_accreditation')->nullable();
            $table->string('school_day_end', 15)->after('school_day_start')->nullable();
            $table->time('school_day_open')->after('school_day_end')->nullable();
            $table->time('school_day_close')->after('school_day_open')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn('school_curiculumn');
            $table->dropColumn('school_address');
            $table->dropColumn('school_map_address');
            $table->dropColumn('school_phone_number');
            $table->dropColumn('school_email');
            $table->dropColumn('school_fee_monthly');
            $table->dropColumn('school_accreditation');
            $table->dropColumn('school_day_start');
            $table->dropColumn('school_day_end');
            $table->dropColumn('school_day_open');
            $table->dropColumn('school_day_close');
        });
    }
}

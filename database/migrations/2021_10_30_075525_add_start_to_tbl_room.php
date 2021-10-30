<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartToTblRoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_room', function (Blueprint $table) {
            $table->string('start')->nullable();
            $table->string('end')->nullable();
            $table->string('startTime')->nullable();
            $table->string('endTime')->nullable();
            $table->string('daysOfWeek')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_room', function (Blueprint $table) {
            $table->dropColumn('start');
            $table->dropColumn('end');
            $table->dropColumn('startTime');
            $table->dropColumn('endTime');
            $table->dropColumn('daysOfWeek');
        });
    }
}

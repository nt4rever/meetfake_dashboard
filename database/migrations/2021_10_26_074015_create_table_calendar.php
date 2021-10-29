<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCalendar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_calendar', function (Blueprint $table) {
            $table->id("id");
            $table->unsignedBigInteger("user_id");
            $table->string("title")->nullable();
            $table->string("start")->nullable();
            $table->string("end")->nullable();
            $table->string("allDay")->nullable();
            $table->string("daysOfWeek")->nullable();
            $table->string("url")->nullable();
            $table->string("backgroundColor")->nullable();
            $table->string("borderColor")->nullable();
            $table->string("edit")->default("true");
            $table->foreign('user_id')->references('id')->on('tbl_user')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_calendar');
    }
}

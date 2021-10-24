<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRoomDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_room_detail', function (Blueprint $table) {
            $table->id("id");
            $table->unsignedBigInteger("room_id");
            $table->unsignedBigInteger("user_id");
            $table->string("auth", 20)->default("attendance");
            $table->foreign('room_id')->references('id')->on('tbl_room')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_room_detail');
    }
}

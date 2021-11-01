<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblTracking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tracking', function (Blueprint $table) {
            $table->id("id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("room_id");
            $table->string("start")->nullable();
            $table->string("end")->nullable();
            $table->string("ip")->nullable();
            $table->foreign('user_id')->references('id')->on('tbl_user')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('tbl_room')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_tracking');
    }
}

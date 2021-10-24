<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_room', function (Blueprint $table) {
            $table->id("id");
            $table->string("roomId");
            $table->string("title")->nullable();
            $table->tinyInteger("status")->default(0);
            $table->unsignedBigInteger("host");
            $table->foreign('host')->references('id')->on('tbl_user')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_room');
    }
}

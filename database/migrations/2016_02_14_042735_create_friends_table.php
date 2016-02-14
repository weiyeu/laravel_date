<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('user_nickname');
            $table->integer('friend_id')->unsigned();
            $table->string('friend_nickname');
            $table->string('friend_email');
            $table->timestamps();
        });
        Schema::table('friends', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('user_nickname')->references('nickname')->on('users');
            $table->foreign('friend_id')->references('id')->on('users');
            $table->foreign('friend_nickname')->references('nickname')->on('users');
            $table->foreign('friend_email')->references('email')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('friends');
    }
}

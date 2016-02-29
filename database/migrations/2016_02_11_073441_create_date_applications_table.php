<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('city');
            $table->integer('start_time')->unsigned();
            $table->integer('end_time')->unsigned();
            $table->string('vegetarian_type');
            $table->string('meal_type');
            $table->string('sex_constraint');
            $table->string('dress_code');
            $table->text('message');
            $table->timestamps();
        });
        Schema::table('date_applications', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('date_applications');
    }
}

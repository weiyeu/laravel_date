<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname')->unique();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('real_name');
            $table->enum('sex',['male','female']);
            $table->integer('year');
            $table->integer('month');
            $table->integer('date');
            $table->string('phone_number',20)->nullable();
            $table->text('self_introduction')->nullable();
            $table->string('profile_image_path',500);
            $table->boolean('confirmed')->default(false);
            $table->string('confirmation_code')->nullable();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}

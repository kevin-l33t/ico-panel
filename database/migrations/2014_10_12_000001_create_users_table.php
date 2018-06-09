<?php

use Illuminate\Support\Facades\Schema;
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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('country');
            $table->date('dob');
            $table->boolean('email_verified')->default(false);
            $table->boolean('kyc_verified')->default(false);
            $table->tinyInteger('status');
            $table->string('password');
            $table->string('profile_picture', 512)->nullable();
            $table->string('profile_thumb', 512)->nullable();
            $table->string('whitepaper', 512)->nullable();
            $table->integer('role_id')->unsigned();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('user_roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

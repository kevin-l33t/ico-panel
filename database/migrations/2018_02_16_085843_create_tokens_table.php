<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string("address", 42)->nullable();
            $table->string("tx_hash", 66);
            $table->string("token_name");
            $table->string("token_symbol");
            $table->integer("rate");
            $table->integer("hard_cap");
            $table->string("artist_address", 42);
            $table->dateTime("sale_start_date");
            $table->integer("stage1_bonus");
            $table->integer("stage2_bonus");
            $table->integer("stage3_bonus");
            $table->integer("stage4_bonus");
            $table->tinyInteger("status")->default(0);

            $table->timestamps();
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
        Schema::dropIfExists('contracts');
    }
}

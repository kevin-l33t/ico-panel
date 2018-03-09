<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->char('from', 42);
            $table->char('to', 42);
            $table->char("tx_hash", 66);
            $table->unsignedDecimal('eth_value', 12, 4)->nullable();
            $table->unsignedDecimal('token_value', 12, 4)->nullable();
            $table->integer('token_id')->unsigned()->nullable();
            $table->integer('ref_id')->unsigned()->nullable();
            $table->integer('transaction_type_id')->unsigned();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('token_id')->references('id')->on('tokens');
            $table->foreign('from')->references('address')->on('wallets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_logs');
    }
}

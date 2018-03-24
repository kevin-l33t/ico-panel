<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->char('order_id', 14);
            $table->integer('user_id')->unsigned();
            $table->integer('token_id')->unsigned();
            $table->string('bank_name');
            $table->string('account_name');
            $table->string('account_number');
            $table->integer('usd_value');
            $table->unsignedDecimal('token_value', 12, 4);
            $table->unsignedDecimal('eth_value', 12, 4);
            $table->string('receipt', 512);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('token_id')->references('id')->on('tokens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_receipts');
    }
}

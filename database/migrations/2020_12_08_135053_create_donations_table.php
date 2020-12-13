<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payment_id');
            $table->string('payer_id');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('payer_email');
            $table->string('payer_name');
            $table->float('amount', 10, 2);
            $table->string('currency')->nullable();
            $table->string('payment_status');
            $table->timestamps();
        });

        Schema::table('donations', function (Blueprint $table) {
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
        Schema::dropIfExists('donations');
    }
}

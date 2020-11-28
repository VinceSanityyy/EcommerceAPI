<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_contents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cart_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('quantity');
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('cart_contents',function (Blueprint $table){
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cart_id')->references('id')->on('carts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_contents');
    }
}

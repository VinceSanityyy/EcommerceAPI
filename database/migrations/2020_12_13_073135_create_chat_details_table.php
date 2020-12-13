<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chat_id')->unsigned();
            $table->bigInteger('participantId')->unsigned();
            $table->bigInteger('reciever_id')->unsigned();
            $table->text('content');
            // $table->boolean('myself')->default(false);
            $table->text('image')->nullable();
            $table->boolean('uploaded')->default(true);
            $table->boolean('viewed')->default(false);
            $table->string('type')->default('text');
            $table->dateTime('dateTimestamp')->nullable();
            $table->timestamps();
        });

        Schema::table('chat_details', function (Blueprint $table) {
            $table->foreign('participantId')->references('id')->on('users');
            $table->foreign('reciever_id')->references('id')->on('users');
            $table->foreign('chat_id')->references('id')->on('chats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_details');
    }
}

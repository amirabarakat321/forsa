<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('chat_id');
            $table->foreign('chat_id')->references('id')->on('chats');
            $table->longText('message');
            $table->string('attachment_type')->comment('image, file, video, text');
            $table->integer('chat_type')->comment('1 => text, 2 => image, 3 => file');
            $table->integer('msg_from');
            $table->integer('msg_to');
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
        Schema::dropIfExists('conversations');
    }
}

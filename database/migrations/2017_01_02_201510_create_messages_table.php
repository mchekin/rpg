<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_id')->unsigned();
            $table->integer('to_id')->unsigned()->nullable();
            $table->integer('root_id')->unsigned()->nullable();
            // $table->text('title');
            $table->text('content');
            $table->integer('state')->default(0);

            $table->integer('archived_at_from')->default(0);
            $table->integer('archived_at_to')->default(0);
            $table->timestamps();

            $table->foreign('root_id')->references('id')->on('messages');
            $table->foreign('from_id')->references('id')->on('users');
            $table->foreign('to_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('messages');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
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

            $table->text('content');
            $table->integer('state')->default(1);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('from_id')->references('id')->on('character');
            $table->foreign('to_id')->references('id')->on('character');
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

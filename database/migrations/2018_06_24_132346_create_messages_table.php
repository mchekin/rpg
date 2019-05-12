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
            $table->uuid('id')->primary();

            $table->uuid('from_id');
            $table->uuid('to_id')->nullable();

            $table->text('content');
            $table->enum('state', ['unread', 'read'])->default('unread');

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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBattleTurnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battle_turns', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('damage')->default(0);

            $table->unsignedInteger('executor_id');
            $table->foreign('executor_id')->references('id')->on('characters')->onDelete('restrict');

            $table->unsignedInteger('target_id');
            $table->foreign('target_id')->references('id')->on('characters')->onDelete('restrict');

            $table->unsignedInteger('battle_round_id');
            $table->foreign('battle_round_id')->references('id')->on('battle_rounds')->onDelete('restrict');

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
        Schema::dropIfExists('battle_turns');
    }
}

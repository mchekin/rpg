<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBattlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battles', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('location_id');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('restrict');

            $table->unsignedInteger('attacker_id');
            $table->foreign('attacker_id')->references('id')->on('characters')->onDelete('restrict');

            $table->unsignedInteger('defender_id');
            $table->foreign('defender_id')->references('id')->on('characters')->onDelete('restrict');

            $table->unsignedInteger('victor_id')->nullable();
            $table->foreign('victor_id')->references('id')->on('characters')->onDelete('restrict');

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
        Schema::dropIfExists('battles');
    }
}

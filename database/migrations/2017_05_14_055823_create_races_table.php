<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('races', function (Blueprint $table) {
            $table->increments('id');

            $table->string("name");
            $table->string("description");

            $table->string("male_image");
            $table->string("female_image");

            // attributes
            $table->integer('strength');
            $table->integer('agility');
            $table->integer('constitution');
            $table->integer('intelligence');
            $table->integer('charisma');

            // locations
            $table->unsignedInteger('starting_location_id');
            $table->foreign('starting_location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('restrict');

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
        Schema::dropIfExists('races');
    }
}

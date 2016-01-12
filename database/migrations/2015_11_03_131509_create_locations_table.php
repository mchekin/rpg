<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->unique();
            $table->string('description');

            $table->string("image");
            $table->string("image_sm");

            // location to the north of the current location
            $table->unsignedInteger('north_location_id')->nullable();
            $table->foreign('north_location_id')
                ->references('id')
                ->on('locations');

            // location to the east of the current location
            $table->unsignedInteger('east_location_id')->nullable();
            $table->foreign('east_location_id')
                ->references('id')
                ->on('locations');

            // location to the south of the current location
            $table->unsignedInteger('south_location_id')->nullable();
            $table->foreign('south_location_id')
                ->references('id')
                ->on('locations');

            // location to the west of the current location
            $table->unsignedInteger('west_location_id')->nullable();
            $table->foreign('west_location_id')
                ->references('id')
                ->on('locations');

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
        Schema::drop('locations');
    }
}

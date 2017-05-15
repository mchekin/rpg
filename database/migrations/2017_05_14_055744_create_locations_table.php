<?php

use App\Location;
use Illuminate\Support\Facades\Schema;
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

            $table->timestamps();
        });

        Schema::create('adjacent_location', function(Blueprint $table) {

            $table->integer('location_id')->unsigned()->index();
            $table->integer('adjacent_location_id')->unsigned()->index();

            $table->primary(['location_id', 'adjacent_location_id']);

            $table->enum('direction', Location::getDirections());

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('adjacent_location_id')->references('id')->on('locations')->onDelete('cascade');

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
        Schema::dropIfExists('adjacent_location');
        Schema::dropIfExists('locations');
    }
}

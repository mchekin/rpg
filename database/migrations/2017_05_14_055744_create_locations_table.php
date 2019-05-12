<?php

use App\Location;
use App\Traits\GeneratesUuid;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    use GeneratesUuid;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name')->unique();
            $table->string('description');

            $table->string("image");
            $table->string("image_sm");

            $table->timestamps();
        });

        Schema::create('adjacent_location', function(Blueprint $table) {

            $table->uuid('location_id')->index();
            $table->uuid('adjacent_location_id')->index();

            $table->primary(['location_id', 'adjacent_location_id']);

            $table->enum('direction', Location::getDirections());

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('adjacent_location_id')->references('id')->on('locations')->onDelete('cascade');

            $table->timestamps();
        });

        $locations = [
            [
                "id"            => $this->generateUuid(),
                "name"          => "Inn",
                "description"   => "An establishment or building providing lodging and, usually, food and drink for travelers (Starting location)",
                "image"         => "locations/Inn-800px.png",
                "image_sm"      => "locations/Inn-300px.png",
            ],
            [
                "id"            => $this->generateUuid(),
                "name"          => "Town Hall",
                "description"   => "Public forum or meeting in which those attending gather to discuss civic or political issues, hear and ask questions about the ideas of a candidate for public office",
                "image"         => "locations/Townhall-800px.png",
                "image_sm"      => "locations/Townhall-300px.png",
            ],
            [
                "id"            => $this->generateUuid(),
                "name"          => "Smithy",
                "description"   => "A blacksmith's shop. A place to purchase weaponry and armor or train one's skill as a blacksmith",
                "image"         => "locations/Blacksmith-800px.png",
                "image_sm"      => "locations/Blacksmith-300px.png",
            ],
            [
                "id"            => $this->generateUuid(),
                "name"          => "Military academy fortress",
                "description"   => "An institute where soldiers and mercenaries train they martial skills",
                "image"         => "locations/Fortress-800px.png",
                "image_sm"      => "locations/Fortress-300px.png",
            ],
        ];

        foreach ($locations as $location)
        {
            Location::query()->forceCreate($location);
        }

        $adjacent_locations = [
            [
                "location_id"           => $locations[0]['id'],
                "adjacent_location_id"  => $locations[1]['id'],
                "direction"             => "north",
            ],
            [
                "location_id"           => $locations[0]['id'],
                "adjacent_location_id"  => $locations[2]['id'],
                "direction"             => "east",
            ],
            [
                "location_id"           => $locations[0]['id'],
                "adjacent_location_id"  => $locations[3]['id'],
                "direction"             => "south",
            ],
        ];

        foreach ($adjacent_locations as $record) {
            /** @var  $location \App\Location */
            $location = Location::query()->find($record['location_id']);

            /** @var  $adjacent_location \App\Location */
            $adjacent_location = Location::query()->find($record['adjacent_location_id']);

            $location->addAdjacentLocation($adjacent_location, $record['direction']);
        }
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

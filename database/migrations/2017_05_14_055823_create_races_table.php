<?php

use App\Race;
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

        $races = [
            [
                "id" => 1,
                "name" => "Human",
                "description" => "This race combines in itself all the properties of the other races, albeit they are less pronounced.",

                "male_image" => "images/races/human-male.png",
                "female_image" => "images/races/human-female.png",

                "strength" => 5,
                "agility" => 5,
                "constitution" => 5,
                "intelligence" => 5,
                "charisma" => 1,

                "starting_location_id" => 1,
            ],
            [
                "id" => 2,
                "name" => "Elf",
                "description" => "This race is known for it's great agility, but lacks constitution.",

                "male_image" => "images/races/elf-male.png",
                "female_image" => "images/races/elf-female.png",

                "strength" => 5,
                "agility" => 9,
                "constitution" => 1,
                "intelligence" => 5,
                "charisma" => 1,

                "starting_location_id" => 1,
            ],
            [
                "id" => 3,
                "name" => "Dwarf",
                "description" => "This race is known for it's constitution and resilience, but lack agility and grace.",

                "male_image" => "images/races/dwarf-male.png",
                "female_image" => "images/races/dwarf-female.png",

                "strength" => 5,
                "agility" => 1,
                "constitution" => 9,
                "intelligence" => 5,
                "charisma" => 1,

                "starting_location_id" => 1,
            ],
            [
                "id" => 4,
                "name" => "Orc",
                "description" => "This race enjoys great physical strength, but lacks intelligence.",

                "male_image" => "images/races/orc-male.png",
                "female_image" => "images/races/orc-female.png",

                "strength" => 9,
                "agility" => 5,
                "constitution" => 5,
                "intelligence" => 1,
                "charisma" => 1,

                "starting_location_id" => 1,
            ],
        ];

        foreach ($races as $race)
        {
            Race::query()->forceCreate($race);
        }
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

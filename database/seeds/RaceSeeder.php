<?php

use App\Race;
use Illuminate\Database\Seeder;

class RaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('races')->delete();

        $races = [
            [
                "id" => 1,
                "name" => "Human",
                "description" => "This race combines in itself all the properties of the other races, albeit they are less pronounced.",

                "male_image" => "races/human-male.png",
                "female_image" => "races/human-female.png",

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

                "male_image" => "races/elf-male.png",
                "female_image" => "races/elf-female.png",

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

                "male_image" => "races/dwarf-male.png",
                "female_image" => "races/dwarf-female.png",

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

                "male_image" => "races/orc-male.png",
                "female_image" => "races/orc-female.png",

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
            Race::create($race);
        }
    }
}

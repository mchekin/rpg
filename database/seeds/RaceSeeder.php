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
                "name" => "Human",
                "description" => "This race combines in itself all the properties of the other races, albeit they are less pronounced.",
                "strength" => 5,
                "agility" => 5,
                "constitution" => 5,
                "intelligence" => 5,
                "charisma" => 1,
            ],
            [
                "name" => "Elf",
                "description" => "This race is known for it's great agility, but lacks constitution.",
                "strength" => 5,
                "agility" => 9,
                "constitution" => 1,
                "intelligence" => 5,
                "charisma" => 1,
            ],
            [
                "name" => "Dwarf",
                "description" => "This race is known for it's constitution and resilience, but lack agility and grace.",
                "strength" => 5,
                "agility" => 1,
                "constitution" => 9,
                "intelligence" => 5,
                "charisma" => 1,
            ],
            [
                "name" => "Orc",
                "description" => "This race enjoys great physical strength, but lacks intelligence.",
                "strength" => 9,
                "agility" => 5,
                "constitution" => 5,
                "intelligence" => 1,
                "charisma" => 1,
            ],
        ];

        foreach ($races as $race)
        {
            Race::create($race);
        }
    }
}

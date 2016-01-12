<?php

use App\Character;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('characters')->delete();

        $characters = [
            [
                "id" => 1,
                "name" => "Jack Daniels",
                "gender" => 'male',

                "xp" => 0,
                "level" => 1,
                "reputation" => 0,
                "money" => 100,

                "strength" => 5,
                "agility" => 5,
                "constitution" => 5,
                "intelligence" => 5,
                "charisma" => 1,

                "user_id" => 1,
                "location_id" => 1,
                "race_id" => 1,
            ],
            [
                "id" => 2,
                "name" => "Blood Axe",
                "gender" => 'male',

                "xp" => 0,
                "level" => 1,
                "reputation" => 0,
                "money" => 0,

                "strength" => 5,
                "agility" => 1,
                "constitution" => 9,
                "intelligence" => 5,
                "charisma" => 1,

                "user_id" => null,
                "location_id" => 1,
                "race_id" => 3,
            ],
            [
                "id" => 3,
                "name" => "Selena",
                "gender" => 'female',

                "xp" => 0,
                "level" => 1,
                "reputation" => 0,
                "money" => 0,

                "strength" => 5,
                "agility" => 9,
                "constitution" => 1,
                "intelligence" => 5,
                "charisma" => 1,

                "user_id" => null,
                "location_id" => 1,
                "race_id" => 2,
            ],
            [
                "id" => 4,
                "name" => "Ogrok",
                "gender" => 'female',

                "xp" => 0,
                "level" => 1,
                "reputation" => 0,
                "money" => 0,

                "strength" => 5,
                "agility" => 1,
                "constitution" => 9,
                "intelligence" => 5,
                "charisma" => 1,

                "user_id" => null,
                "location_id" => 1,
                "race_id" => 4,
            ],
        ];

        foreach ($characters as $char)
        {
            Character::create($char);
        }
    }
}

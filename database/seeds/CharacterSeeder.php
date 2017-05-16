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

        Character::query()->create([
            "id" => 1,
            "name" => "Jack Daniels",
            "gender" => 'male',

            "xp" => 0,
            "level" => 1,
            "reputation" => 0,
            "hit_points" => 45,
            "total_hit_points" => 55,
            "money" => 100,

            "strength" => 5,
            "agility" => 5,
            "constitution" => 5,
            "intelligence" => 5,
            "charisma" => 1,

            "user_id" => 1,
            "location_id" => 1,
            "race_id" => 1,
        ]);

        factory(Character::class, 50)->create();
    }
}

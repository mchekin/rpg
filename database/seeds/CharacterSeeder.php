<?php

use App\Character;
use App\User;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

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

        $totalHitPoints = 100;

        /** @var User $user */
        $user = User::query()->first();

        Character::query()->create([
            "id" => Uuid::uuid4(),
            "name" => "Jack Daniels",
            "gender" => 'male',

            "xp" => 0,
            "reputation" => 0,
            "hit_points" => $totalHitPoints,
            "total_hit_points" => $totalHitPoints,
            "money" => 100,

            "strength" => 5,
            "agility" => 5,
            "constitution" => 5,
            "intelligence" => 5,
            "charisma" => 1,

            "level_id" => 1,
            "user_id" => $user->getId(),
            "location_id" => 1,
            "race_id" => 1,
        ]);

        factory(Character::class, 50)->create();
    }
}

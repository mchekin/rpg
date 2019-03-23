<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Character;
use App\Level;
use App\Location;
use App\Race;
use App\User;
use Illuminate\Database\Eloquent\Factory;
use Ramsey\Uuid\Uuid;

/** @var Factory $factory */

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'id'             => Uuid::uuid4(),
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Character::class, function (Faker\Generator $faker) use ($factory) {

    $level = Level::query()->inRandomOrder()->first();
    $location = Location::query()->inRandomOrder()->first();
    $race = Race::query()->inRandomOrder()->first();

    $constitution = rand(1, 9);
    $total_hit_points = $constitution * $level->id;
    $hit_points = rand(1, $total_hit_points);

    $genders = ['male', 'female'];

    return [
        'id'               => Uuid::uuid4(),

        'name'   => $faker->name,
        'gender' => $genders[array_rand($genders)],

        'xp'               => 0,
        'reputation'       => rand(-1000, 1000),
        'hit_points'       => $hit_points,
        'total_hit_points' => $total_hit_points,
        'money'            => rand(0, 5000),

        // attributes
        'strength'         => rand(1, 9),
        'agility'          => rand(1, 9),
        'constitution'     => $constitution,
        'intelligence'     => rand(1, 9),
        'charisma'         => rand(1, 9),

        'level_id'         => $level,

        'user_id' => function () {
            return rand(0, 3)
                ? factory(User::class)->create()->id
                : null;
        },

        'location_id' => $location,

        'race_id' => $race,
    ];
});

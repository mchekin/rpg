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
use App\User;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Character::class, function (Faker\Generator $faker) use ($factory) {

    $level = rand(1, 9);
    $constitution = rand(1, 9);
    $total_hit_points = $constitution * $level;
    $hit_points = rand(1, $total_hit_points);

    return [

        'name'   => $faker->name,
        'gender' => array_rand(['male', 'female']),

        'xp'               => 0,
        'level'            => 1,
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

        'user_id' => function () {
            return rand(0, 3)
                ? factory(User::class)->create()->id
                : null;
        },

        'location_id' => rand(1, 4),

        'race_id' => rand(1, 4),
    ];
});

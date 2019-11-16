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
use App\Location;
use App\Modules\Character\Domain\ValueObjects\HitPoints;
use App\Modules\Character\Infrastructure\Repositories\RaceRepository;
use App\Race;
use App\User;
use Illuminate\Database\Eloquent\Factory;
use Ramsey\Uuid\Uuid;

/** @var Factory $factory */

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Character::class, function (Faker\Generator $faker) use ($factory) {

    /** @var Race $raceModel */
    $raceModel = Race::query()->inRandomOrder()->first();
    $location = Location::query()->inRandomOrder()->first();

    $race = (new RaceRepository())->getOne($raceModel->getId());
    $hitPoints = HitPoints::byRace($race);

    $genders = ['male', 'female'];

    return [
        'id' => Uuid::uuid4(),

        'race_id' => $race->getId(),

        'level_id' => 1,

        'location_id' => $location,

        'name' => $faker->name,
        'gender' => $genders[array_rand($genders)],

        'xp' => 0,
        'money' => rand(0, 5000),
        'reputation' => 0,

        // attributes
        'strength' => $race->getStrength(),
        'agility' => $race->getAgility(),
        'constitution' => $race->getConstitution(),
        'intelligence' => $race->getIntelligence(),
        'charisma' => $race->getCharisma(),

        'hit_points' => $hitPoints->getCurrentHitPoints(),
        'total_hit_points' => $hitPoints->getMaximumHitPoints(),

        'user_id' => function () {
            return rand(0, 3)
                ? factory(User::class)->create()->id
                : null;
        },
    ];
});

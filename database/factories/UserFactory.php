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
use App\ItemPrototype;
use App\Location;
use App\Modules\Character\Domain\ValueObjects\HitPoints;
use App\Modules\Character\Infrastructure\Repositories\RaceRepository;
use App\Race;
use App\User;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

/** @var Factory $factory */

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Character::class, function (Faker\Generator $faker) use ($factory) {

    /** @var Race $raceModel */
    $raceModel = Race::query()->inRandomOrder()->first();
    $location = Location::query()->inRandomOrder()->first();

    $race = app(RaceRepository::class)->getOne($raceModel->getId());
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

        'hit_points' => $hitPoints->getHitPoints(),
        'total_hit_points' => $hitPoints->getTotalHitPoints(),

        'user_id' => function () {
            return rand(0, 3)
                ? factory(User::class)->create()->id
                : null;
        },
    ];
});

$factory->define(App\Item::class, function () {
    static $charactersIds = [];

    /** @var ItemPrototype $itemPrototype */
    $itemPrototype = ItemPrototype::query()->inRandomOrder()->first();

    /** @var Character $character */
    $character = Character::query()->whereNotIn('id', $charactersIds)->first();

    $charactersIds[] = $character->getId();

    return [
        'id' => Uuid::uuid4(),
        "name" => $itemPrototype->getName(),
        "description" => $itemPrototype->getDescription(),
        "effects" => $itemPrototype->getEffects(),
        'inventory_slot_number' => 0,
        'equipped' => true,
        "type" => $itemPrototype->getType(),
        "image_file_path" => $itemPrototype->getImageFilePath(),
        "prototype_id" => $itemPrototype->getId(),
        "creator_character_id" => $character->getId(),
        "owner_character_id" => $character->getId(),
    ];
});

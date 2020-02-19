<?php

use App\Character;
use App\Item;
use App\ItemPrototype;
use App\Location;
use App\Traits\GeneratesUuid;
use App\User;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    use GeneratesUuid;

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

        /** @var Location $location */
        $location = Location::query()->firstOrFail();

        /** @var Character $someone */
        $someone = Character::query()->create([
            "id" => $this->generateUuid(),
            "name" => "Someone",
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
            "location_id" => $location->getId(),
            "race_id" => 1,
        ]);

        ItemPrototype::query()->get()->each(function (ItemPrototype $weaponPrototype, int $slot) use ($someone) {
            Item::query()->create([
                "id" => $this->generateUuid(),
                "name" => $weaponPrototype->getName(),
                "description" => $weaponPrototype->getDescription(),
                "effects" => $weaponPrototype->getEffects(),
                'inventory_slot_number' => $slot,
                'equipped' => $slot ? false : true,
                "type" => $weaponPrototype->getType(),
                "image_file_path" => $weaponPrototype->getImageFilePath(),
                "prototype_id" => $weaponPrototype->getId(),
                "creator_character_id" => $someone->getId(),
                "owner_character_id" => $someone->getId(),
            ]);
        });

        factory(Character::class, 50)->create();
        factory(Item::class, 50)->create();
    }
}

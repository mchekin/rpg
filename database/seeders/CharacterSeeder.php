<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\ItemPrototype;
use App\Models\Location;
use App\Modules\Character\Application\Contracts\CharacterRepositoryInterface;
use App\Modules\Equipment\Application\Contracts\InventoryRepositoryInterface;
use App\Modules\Equipment\Application\Contracts\ItemRepositoryInterface;
use App\Modules\Equipment\Domain\ItemStatus;
use App\Modules\Trade\Application\Contracts\StoreRepositoryInterface;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        if (Character::query()->count())
        {
            return;
        }

        /** @var CharacterRepositoryInterface $characterRepository */
        $characterRepository = resolve(CharacterRepositoryInterface::class);

        /** @var InventoryRepositoryInterface $inventoryRepository */
        $inventoryRepository = resolve(InventoryRepositoryInterface::class);

        /** @var StoreRepositoryInterface $storeRepository */
        $storeRepository = resolve(StoreRepositoryInterface::class);

        /** @var ItemRepositoryInterface $itemRepository */
        $itemRepository = resolve(ItemRepositoryInterface::class);

        $totalHitPoints = 100;

        /** @var User $user */
        $user = User::query()->first();

        /** @var Location $location */
        $location = Location::query()->firstOrFail();

        /** @var Character $someone */
        $someone = Character::query()->create([
            'id' => $characterRepository->nextIdentity()->toString(),
            'name' => 'Someone',
            'gender' => 'male',

            'xp' => 0,
            'reputation' => 0,
            'hit_points' => $totalHitPoints,
            'total_hit_points' => $totalHitPoints,

            'strength' => 5,
            'agility' => 5,
            'constitution' => 5,
            'intelligence' => 5,
            'charisma' => 1,

            'level_id' => 1,
            'user_id' => $user->getId(),
            'location_id' => $location->getId(),
            'race_id' => 1,
        ]);

        /** @var Inventory $inventory */
        $inventory = Inventory::query()->create([
            'id' => $inventoryRepository->nextIdentity()->toString(),
            'character_id' => $someone->getId(),
            'money' => 100,
        ]);

        Store::query()->create([
            'id' => $storeRepository->nextIdentity()->toString(),
            'character_id' => $someone->getId(),
            'money' => 1000,
        ]);

        ItemPrototype::query()->get()
            ->each(static function (ItemPrototype $weaponPrototype, int $slot) use ($someone, $inventory, $itemRepository) {

                /** @var Item $item */
                $item = Item::query()->create([
                    'id' => $itemRepository->nextIdentity()->toString(),
                    'name' => $weaponPrototype->getName(),
                    'description' => $weaponPrototype->getDescription(),
                    'effects' => $weaponPrototype->getEffects(),
                    'price' => $weaponPrototype->getPrice(),
                    'type' => $weaponPrototype->getType(),
                    'image_file_path' => $weaponPrototype->getImageFilePath(),
                    'prototype_id' => $weaponPrototype->getId(),
                    'creator_character_id' => $someone->getId(),
                ]);

                $inventory->items()->attach($item->getId(), [
                    'inventory_slot_number' => $slot,
                    'status' => $slot ? ItemStatus::IN_BACKPACK : ItemStatus::EQUIPPED,
                ]);
            });

        factory(Character::class, 50)->create();
        factory(Item::class, 50)->create();
    }
}

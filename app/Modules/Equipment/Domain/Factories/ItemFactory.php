<?php

namespace App\Modules\Equipment\Domain\Factories;

use App\Modules\Equipment\Domain\Entities\Item;
use App\Modules\Equipment\Domain\Entities\ItemPrototype;
use App\Traits\GeneratesUuid;


class ItemFactory
{
    use GeneratesUuid;

    public function create(ItemPrototype $itemPrototype, string $creatorCharacterId): Item
    {
        return new Item(
            $itemPrototype->getTitle(),
            $itemPrototype->getDescription(),
            $itemPrototype->getType(),
            $itemPrototype->getEffects(),
            $creatorCharacterId
        );
    }
}
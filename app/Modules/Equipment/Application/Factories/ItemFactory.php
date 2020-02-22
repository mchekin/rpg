<?php

namespace App\Modules\Equipment\Application\Factories;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\Item;
use App\Modules\Equipment\Domain\ItemPrototype;
use App\Modules\Equipment\Domain\InventorySlot;
use App\Traits\GeneratesUuid;


class ItemFactory
{
    use GeneratesUuid;

    public function create(ItemPrototype $itemPrototype, CharacterId $creatorCharacterId): Item
    {
        return new Item(
            $this->generateUuid(),
            $itemPrototype->getName(),
            $itemPrototype->getDescription(),
            $itemPrototype->getImageFilePath(),
            $itemPrototype->getType(),
            $itemPrototype->getEffects(),
            $itemPrototype->getId(),
            $creatorCharacterId,
            $creatorCharacterId,
            InventorySlot::undefined()
        );
    }
}

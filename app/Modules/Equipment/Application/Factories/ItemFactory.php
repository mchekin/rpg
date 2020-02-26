<?php

namespace App\Modules\Equipment\Application\Factories;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\Item;
use App\Modules\Equipment\Domain\ItemId;
use App\Modules\Equipment\Domain\ItemPrototype;
use App\Modules\Equipment\Domain\InventorySlot;
use App\Modules\Equipment\Domain\ItemStatus;


class ItemFactory
{
    public function create(ItemId $itemId, ItemPrototype $itemPrototype, CharacterId $creatorCharacterId): Item
    {
        return new Item(
            $itemId,
            $itemPrototype->getName(),
            $itemPrototype->getDescription(),
            $itemPrototype->getImageFilePath(),
            $itemPrototype->getType(),
            ItemStatus::inBackpack(),
            $itemPrototype->getEffects(),
            $itemPrototype->getPrice(),
            $itemPrototype->getId(),
            $creatorCharacterId,
            $creatorCharacterId,
            InventorySlot::undefined()
        );
    }
}

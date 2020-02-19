<?php

namespace App\Modules\Equipment\Application\Factories;

use App\Modules\Equipment\Domain\Entities\Item;
use App\Modules\Equipment\Domain\Entities\ItemPrototype;
use App\Modules\Equipment\Domain\ValueObjects\InventorySlot;
use App\Traits\GeneratesUuid;


class ItemFactory
{
    use GeneratesUuid;

    public function create(ItemPrototype $itemPrototype, string $creatorCharacterId): Item
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

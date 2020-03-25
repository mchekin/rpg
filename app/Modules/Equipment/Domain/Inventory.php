<?php

namespace App\Modules\Equipment\Domain;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\Inventory\InventorySlotIsTakenException;
use App\Modules\Equipment\Domain\Inventory\InventorySlotOutOfRangeException;
use App\Modules\Equipment\Domain\Inventory\InventoryIsFullException;
use App\Modules\Equipment\Domain\Inventory\ItemNotInInventory;
use App\Modules\Equipment\Domain\Inventory\NotEnoughSpaceException;
use Illuminate\Support\Collection;

class Inventory
{
    public const NUMBER_OF_SLOTS = 24;

    /**
     * @var InventoryId
     */
    private $id;

    /**
     * @var CharacterId
     */
    private $characterId;

    /**
     * @var Collection
     */
    private $items;

    public function __construct(InventoryId $id, CharacterId $characterId, Collection $items)
    {
        if ($items->count() >= self::NUMBER_OF_SLOTS) {
            throw new NotEnoughSpaceException("Not enough space in the Inventory for {$items->count()} new items");
        }

        $this->id = $id;
        $this->characterId = $characterId;
        $this->items = $items;
    }

    public function getId(): InventoryId
    {
        return $this->id;
    }

    public function addItemToSlot(int $slot, InventoryItem $item): void
    {
        if ($slot >= self::NUMBER_OF_SLOTS) {
            throw new InventorySlotOutOfRangeException("Inventory slot $slot is out of range.");
        }

        if ($this->items->has($slot)) {
            throw new InventorySlotIsTakenException("Inventory slot $slot is already take");
        }

        $this->items->put($slot, $item);
    }

    public function add(Item $item): void
    {
        $slot = $this->findFreeSlot();

        $this->items->put($slot, $item);
    }

    private function findFreeSlot(): int
    {
        for ($slot = 0; $slot < self::NUMBER_OF_SLOTS; $slot++) {
            if (!$this->items->has($slot)) {
                return $slot;
            }
        }

        throw new InventoryIsFullException('Cannot add to full inventory');
    }

    public function findItem(ItemId $itemId):? InventoryItem
    {
        return $this->items->first(static function (InventoryItem $item) use ($itemId) {
            return $item->getId()->equals($itemId);
        });
    }

    public function findEquippedItem(ItemId $itemId):? InventoryItem
    {
        return $this->items->first(static function (InventoryItem $item) use ($itemId) {
            return $item->getId()->equals($itemId) && $item->isEquipped();
        });
    }

    public function findEquippedItemOfType(ItemType $type):? InventoryItem
    {
        return $this->items->first(static function (InventoryItem $item) use ($type) {
            return $item->isOfType($type) && $item->isEquipped();
        });
    }

    public function hasItem(InventoryItem $itemToFind): bool
    {
        return $this->items->contains(static function (InventoryItem $item) use ($itemToFind) {
            return $item->equals($itemToFind);
        });
    }

    public function getEquippedItemsEffect(string $itemEffectType): int
    {
        return (int)$this->getEquippedItems()->reduce(static function ($carry, InventoryItem $item) use ($itemEffectType) {

            $itemEffect = $item->getItemEffect($itemEffectType);

            return $carry + $itemEffect;
        });
    }

    private function getEquippedItems(): Collection
    {
        return $this->items->filter(static function (InventoryItem $item) {
            return $item->isEquipped();
        });
    }

    public function unEquipItem(ItemId $itemId): void
    {
        $equippedItem = $this->findEquippedItem($itemId);

        if ($equippedItem)
        {
            $equippedItem->unEquip();
        }
    }

    public function equip(ItemId $itemId): void
    {
        $item = $this->findItem($itemId);
        if (!$item) {
            throw new ItemNotInInventory('Cannot equip item that is not in the inventory');
        }

        if ($equippedItem = $this->findEquippedItemOfType($item->getType())) {
            $equippedItem->unEquip();
        }

        $item->equip();
    }

    public function getCharacterId(): CharacterId
    {
        return $this->characterId;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }
}

<?php

namespace App\Modules\Equipment\Domain;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Generic\Domain\Container\ContainerSlotIsTakenException;
use App\Modules\Generic\Domain\Container\ContainerSlotOutOfRangeException;
use App\Modules\Generic\Domain\Container\ContainerIsFullException;
use App\Modules\Generic\Domain\Container\ItemNotInContainer;
use App\Modules\Generic\Domain\Container\NotEnoughSpaceInContainerException;
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

    /**
     * @var Money
     */
    private $money;

    public function __construct(InventoryId $id, CharacterId $characterId, Collection $items, Money $money)
    {
        if ($items->count() >= self::NUMBER_OF_SLOTS) {
            throw new NotEnoughSpaceInContainerException(
                "Not enough space in the Inventory for {$items->count()} new items"
            );
        }

        $this->id = $id;
        $this->characterId = $characterId;
        $this->items = $items;
        $this->money = $money;
    }

    public function getId(): InventoryId
    {
        return $this->id;
    }

    public function add(Item $item): void
    {
        $item = new InventoryItem($item, ItemStatus::inBackpack());

        $slot = $this->findFreeSlot();

        $this->items->put($slot, $item);
    }

    public function getEquippedItemsEffect(string $itemEffectType): int
    {
        return (int)$this->getEquippedItems()->reduce(static function ($carry, InventoryItem $item) use ($itemEffectType) {

            $itemEffect = $item->getItemEffect($itemEffectType);

            return $carry + $itemEffect;
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
            throw new ItemNotInContainer('Cannot equip item that is not in the inventory');
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

    public function takeOut(ItemId $itemId): Item
    {
        $slot = $this->items->search(static function (InventoryItem $item) use ($itemId) {
            return $item->getId()->equals($itemId);
        });

        if ($slot === false) {
            throw new ItemNotInContainer('Cannot take out item from empty slot');
        }

        /** @var InventoryItem $item */
        $item = $this->items->get($slot);

        $this->items->forget($slot);

        return $item->toBaseItem();
    }

    public function putMoneyIn(Money $money): void
    {
        $this->money = $this->money->combine($money);
    }

    public function takeMoneyOut(Money $money): Money
    {
        $this->money = $this->money->remove($money);

        return $money;
    }

    public function getMoney(): Money
    {
        return $this->money;
    }

    public function findItemOrFail(ItemId $itemId): InventoryItem
    {
        $item = $this->findItem($itemId);

        if ($item === null) {
            throw new ItemNotInContainer('Cannot find item');
        }

        return $item;
    }

    private function findItem(ItemId $itemId):? InventoryItem
    {
        return $this->items->first(static function (InventoryItem $item) use ($itemId) {
            return $item->getId()->equals($itemId);
        });
    }

    private function findFreeSlot(): int
    {
        for ($slot = 0; $slot < self::NUMBER_OF_SLOTS; $slot++) {
            if (!$this->items->has($slot)) {
                return $slot;
            }
        }

        throw new ContainerIsFullException('Cannot add to full inventory');
    }

    private function findEquippedItem(ItemId $itemId):? InventoryItem
    {
        return $this->items->first(static function (InventoryItem $item) use ($itemId) {
            return $item->getId()->equals($itemId) && $item->isEquipped();
        });
    }

    private function findEquippedItemOfType(ItemType $type):? InventoryItem
    {
        return $this->items->first(static function (InventoryItem $item) use ($type) {
            return $item->isOfType($type) && $item->isEquipped();
        });
    }

    private function getEquippedItems(): Collection
    {
        return $this->items->filter(static function (InventoryItem $item) {
            return $item->isEquipped();
        });
    }
}

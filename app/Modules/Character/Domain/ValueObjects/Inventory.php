<?php

namespace App\Modules\Character\Domain\ValueObjects;

use App\Modules\Character\Domain\ValueObjects\Inventory\InventorySlotIsTakenException;
use App\Modules\Character\Domain\ValueObjects\Inventory\InventorySlotOutOfRangeException;
use App\Modules\Character\Domain\ValueObjects\Inventory\InventoryIsFullException;
use App\Modules\Character\Domain\ValueObjects\Inventory\NotEnoughSpaceException;
use App\Modules\Equipment\Domain\Entities\Item;
use App\Modules\Equipment\Domain\ValueObjects\InventorySlot;
use App\Modules\Equipment\Domain\ValueObjects\ItemType;
use Doctrine\Common\Collections\ArrayCollection;

class Inventory
{
    const NUMBER_OF_SLOTS = 24;

    /**
     * @var ArrayCollection
     */
    private $items;

    private function __construct(ArrayCollection $items)
    {
        $this->items = new ArrayCollection($items->toArray());
    }

    public static function empty(): self
    {
        return new self(new ArrayCollection());
    }

    public static function withItems(ArrayCollection $items): self
    {
        if ($items->count() >= self::NUMBER_OF_SLOTS) {
            throw new NotEnoughSpaceException("Not enough space in the Inventory for {$items->count()} new items");
        }

        return new self($items);
    }

    public function withAddedItem(int $slot, Item $item): self
    {
        if ($slot >= self::NUMBER_OF_SLOTS) {
            throw new InventorySlotOutOfRangeException("Inventory slot $slot is out of range.");
        }

        if ($this->items->contains($slot)) {
            throw new InventorySlotIsTakenException("Inventory slot $slot is already take");
        }

        return $this->addItem($slot, $item);
    }

    public function withAddedItemToFreeSlot(Item $item): self
    {
        $slot = $this->findFreeSlot();

        return $this->addItem($slot, $item);
    }

    public function findFreeSlot(): int
    {
        for ($slot = 0; $slot < self::NUMBER_OF_SLOTS; $slot++) {
            if (!$this->items->contains($slot)) {
                return $slot;
            }
        }

        throw new InventoryIsFullException('Cannot add to full inventory');
    }

    public function findEquippedItemOfType(ItemType $type): Item
    {
        return $this->items->filter(function (Item $item) use ($type) {
            return $item->getType()->equals($type) && $item->isEquipped();
        })->first();
    }

    public function hasItem(Item $itemToFind): bool
    {
        return $this->items->contains(function (Item $item) use ($itemToFind) {
            return $item->getId() === $itemToFind->getId();
        });
    }

    public function getEquippedItemsEffect(string $itemEffectType): int
    {
        return (int)array_reduce($this->getEquippedItems()->toArray(), function ($carry, Item $item) use ($itemEffectType) {

            $itemEffect = $item->getItemEffect($itemEffectType);

            return $carry + $itemEffect;
        });
    }

    private function getEquippedItems(): ArrayCollection
    {
        return $this->items->filter(function (Item $item) {
            return $item->isEquipped();
        });
    }

    /**
     * @param int $slot
     * @param Item $item
     * @return Inventory
     */
    private function addItem(int $slot, Item $item): Inventory
    {
        $item->setInventorySlot(InventorySlot::defined($slot));

        $items = $this->items;
        $items->set($slot, $item);

        return new self($this->items);
    }
}

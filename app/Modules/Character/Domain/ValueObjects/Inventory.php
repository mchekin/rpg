<?php

namespace App\Modules\Character\Domain\ValueObjects;

use App\Modules\Character\Domain\ValueObjects\Inventory\InventorySlotIsTakenException;
use App\Modules\Character\Domain\ValueObjects\Inventory\InventorySlotOutOfRangeException;
use App\Modules\Character\Domain\ValueObjects\Inventory\InventoryIsFullException;
use App\Modules\Character\Domain\ValueObjects\Inventory\NotEnoughSpaceException;
use App\Modules\Equipment\Domain\Entities\Item;
use App\Modules\Equipment\Domain\ValueObjects\InventorySlot;
use App\Modules\Equipment\Domain\ValueObjects\ItemType;
use Illuminate\Support\Collection;

class Inventory
{
    const NUMBER_OF_SLOTS = 24;

    /**
     * @var Collection
     */
    private $items;

    private function __construct(Collection $items)
    {
        $this->items = $items;
    }

    public static function empty(): self
    {
        return new self(new Collection());
    }

    public static function withItems(Collection $items): self
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

        if ($this->items->has($slot)) {
            throw new InventorySlotIsTakenException("Inventory slot $slot is already take");
        }

        $item->setInventorySlot(InventorySlot::defined($slot));

        return new self($this->items->put($slot, $item));
    }

    public function withAddedItemToFreeSlot(Item $item)
    {
        $slot = $this->findFreeSlot();

        $item->setInventorySlot(InventorySlot::defined($slot));

        return new self($this->items->put($slot, $item));
    }

    public function findFreeSlot(): int
    {
        for ($slot = 0; $slot < self::NUMBER_OF_SLOTS; $slot++) {
            if (!$this->items->has($slot)) {
                return $slot;
            }
        }

        throw new InventoryIsFullException('Cannot add to full inventory');
    }

    public function findEquippedItemOfType(ItemType $type)
    {
        return $this->items->first(function (Item $item) use ($type) {
            return $item->getType()->equals($type) && $item->isEquipped();
        });
    }

    public function hasItem(Item $itemToFind)
    {
        return $this->items->contains(function (Item $item) use ($itemToFind) {
            return $item->getId() === $itemToFind->getId();
        });
    }

    public function getEquippedItemsEffect(string $itemEffectType): int
    {
        return (int)$this->getEquippedItems()->reduce(function ($carry, Item $item) use ($itemEffectType) {

            $itemEffect = $item->getItemEffect($itemEffectType);

            return $carry + $itemEffect;
        });
    }

    private function getEquippedItems(): Collection
    {
        return $this->items->filter(function (Item $item) {
            return $item->isEquipped();
        });
    }
}
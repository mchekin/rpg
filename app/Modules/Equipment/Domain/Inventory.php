<?php

namespace App\Modules\Equipment\Domain;

use App\Modules\Equipment\Domain\Inventory\InventorySlotIsTakenException;
use App\Modules\Equipment\Domain\Inventory\InventorySlotOutOfRangeException;
use App\Modules\Equipment\Domain\Inventory\InventoryIsFullException;
use App\Modules\Equipment\Domain\Inventory\NotEnoughSpaceException;
use Illuminate\Support\Collection;

class Inventory
{
    public const NUMBER_OF_SLOTS = 24;

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

    public function withAddedItemToFreeSlot(Item $item): Inventory
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
        return $this->items->first(static function (Item $item) use ($type) {
            return $item->isOfType($type) && $item->isEquipped();
        });
    }

    public function hasItem(Item $itemToFind): bool
    {
        return $this->items->contains(static function (Item $item) use ($itemToFind) {
            return $item->equals($itemToFind);
        });
    }

    public function getEquippedItemsEffect(string $itemEffectType): int
    {
        return (int)$this->getEquippedItems()->reduce(static function ($carry, Item $item) use ($itemEffectType) {

            $itemEffect = $item->getItemEffect($itemEffectType);

            return $carry + $itemEffect;
        });
    }

    private function getEquippedItems(): Collection
    {
        return $this->items->filter(static function (Item $item) {
            return $item->isEquipped();
        });
    }
}

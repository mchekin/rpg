<?php

namespace App\Modules\Character\Domain\ValueObjects;

use App\Modules\Character\Domain\ValueObjects\Inventory\AddToFullSlotException;
use App\Modules\Character\Domain\ValueObjects\Inventory\AddToIlligalSlotException;
use App\Modules\Character\Domain\ValueObjects\Inventory\InventoryIsFullException;
use App\Modules\Character\Domain\ValueObjects\Inventory\NotAnItemException;
use App\Modules\Character\Domain\ValueObjects\Inventory\NotEnoughSpaceException;
use App\Modules\Equipment\Domain\Entities\Item;
use App\Modules\Equipment\Domain\ValueObjects\InventorySlot;

class Inventory
{
    const NUMBER_OF_SLOTS = 60;

    /**
     * @var array
     */
    private $data;

    private function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public static function empty(): self
    {
        return new self();
    }

    public static function withItems(array $items): self
    {
        $numberOfItems = count($items);
        if ($numberOfItems >= self::NUMBER_OF_SLOTS) {
            throw new NotEnoughSpaceException("Not enough space in the Inventory for $numberOfItems new items");
        }

        foreach ($items as $index => $item) {
            if (!($item instanceof Item)) {
                throw new NotAnItemException("Object number $index is not and Item");
            }
        }

        return new self($items);
    }

    public function withAddedItem(int $slot, Item $item): self
    {
        if (isset($this->data[$slot])) {
            throw new AddToFullSlotException('Cannot add to full slot');
        }

        if ($slot >= self::NUMBER_OF_SLOTS) {
            throw new AddToIlligalSlotException('This slot is not in the Inventory');
        }

        $data = $this->data;

        $data[$slot] = $item;

        return new self($data);
    }

    public function withAddedItemToFreeSlot(Item $item)
    {
        $slot = $this->findFreeSlot();

        $data = $this->data;

        $data[$slot] = $item;

        $item->setInventorySlot(InventorySlot::defined($slot));

        return new self($data);
    }

    public function withRemovedItem(int $slot): self
    {
        if (!isset($this->data[$slot])) {
            throw new AddToFullSlotException('Cannot remove from empty slot');
        }

        $data = $this->data;

        unset($data[$slot]);

        return new self($data);
    }

    public function findFreeSlot(): int
    {
        for ($slot = 0; $slot < self::NUMBER_OF_SLOTS; $slot++) {
            if (!isset($this->data[$slot])) {
                return $slot;
            }
        }

        throw new InventoryIsFullException('Cannot add to full inventory');
    }
}
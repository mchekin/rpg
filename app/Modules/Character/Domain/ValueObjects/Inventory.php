<?php

namespace App\Modules\Character\Domain\ValueObjects;

use App\Modules\Character\Domain\ValueObjects\Inventory\AddToFullSlotException;
use App\Modules\Character\Domain\ValueObjects\Inventory\AddToIlligalSlotException;
use App\Modules\Character\Domain\ValueObjects\Inventory\InventoryIsFullException;
use App\Modules\Equipment\Domain\Entities\Item;

class Inventory
{
    const NUMBER_OF_SLOTS = 40;

    /**
     * @var array
     */
    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public static function empty(): self
    {
        return new self();
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
        $slot = $this->findEmptySlot();

        $data = $this->data;

        $data[$slot] = $item;

        return new self($data);
    }

    public function withRemovedItem(int $slot, Item $item): self
    {
        if (!isset($this->data[$slot])) {
            throw new AddToFullSlotException('Cannot remove from empty slot');
        }

        $data = $this->data;

        unset($data[$slot]);

        return new self($data);
    }

    private function findEmptySlot(): int
    {
        for ($slot = 0; $slot < self::NUMBER_OF_SLOTS; $slot++) {
            if (!isset($this->data[$slot])) {
                return $slot;
            }
        }

        throw new InventoryIsFullException('Cannot add to full inventory');
    }
}
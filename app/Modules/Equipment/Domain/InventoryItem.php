<?php

namespace App\Modules\Equipment\Domain;


class InventoryItem extends Item
{
    /**
     * @var ItemStatus
     */
    private $status;

    public function __construct(Item $item, ItemStatus $status)
    {
        parent::__construct(
            $item->getId(),
            $item->getName(),
            $item->getDescription(),
            $item->getImageFilePath(),
            $item->getType(),
            $item->getEffects(),
            $item->getPrice(),
            $item->getPrototypeId(),
            $item->getCreatorCharacterId()
        );

        $this->status = $status;
    }

    public function getStatus(): ItemStatus
    {
        return $this->status;
    }

    public function isEquipped(): bool
    {
        return $this->status->equals(ItemStatus::equipped());
    }

    public function equip(): void
    {
        $this->status = ItemStatus::equipped();
    }

    public function unEquip(): void
    {
        $this->status = ItemStatus::inBackpack();
    }
}

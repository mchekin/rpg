<?php

namespace App\Modules\Trade\Domain;


use App\Modules\Equipment\Domain\Item;
use App\Modules\Equipment\Domain\ItemPrice;

class StoreItem extends Item
{
    /**
     * @var ItemPrice
     */
    private $price;

    public function __construct(Item $item, ItemPrice $price)
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

        $this->price = $price;
    }

    public function getPrice(): ItemPrice
    {
        return $this->price;
    }

    public function changePrice(ItemPrice $price): void
    {
        $this->price = $price;
    }

    public function toBaseItem(): Item
    {
        return new Item(
            $this->getId(),
            $this->getName(),
            $this->getDescription(),
            $this->getImageFilePath(),
            $this->getType(),
            $this->getEffects(),
            $this->getPrice(),
            $this->getPrototypeId(),
            $this->getCreatorCharacterId()
        );
    }
}

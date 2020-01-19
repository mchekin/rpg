<?php

namespace App\Modules\Equipment\Domain\Entities;


use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Equipment\Domain\ValueObjects\InventorySlot;
use App\Modules\Equipment\Domain\ValueObjects\ItemType;
use App\Traits\GeneratesUuid;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ItemPrototype
{
    use GeneratesUuid;

    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $imageFilePath;
    /**
     * @var ItemType
     */
    private $type;
    /**
     * @var array
     */
    private $effects;
    /**
     * @var Collection
     */
    private $items;
    /**
     * @var Carbon
     */
    private $createdAt;
    /**
     * @var Carbon
     */
    private $updatedAt;

    public function __construct(
        string $id,
        string $name,
        string $description,
        string $imageFilePath,
        ItemType $type,
        array $effects
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->imageFilePath = $imageFilePath;
        $this->type = $type;
        $this->effects = $effects;
        $this->items = new ArrayCollection();
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImageFilePath(): string
    {
        return $this->imageFilePath;
    }

    public function getType(): ItemType
    {
        return $this->type;
    }

    public function getEffects(): array
    {
        return $this->effects;
    }

    public function createItem(Character $creator): Item
    {
        return new Item(
            $this->generateUuid(),
            $this->getName(),
            $this->getDescription(),
            $this->getImageFilePath(),
            $this->getType(),
            $this->getEffects(),
            $creator,
            $this,
            InventorySlot::defined($creator->getInventory()->findFreeSlot())
        );
    }
}

<?php

namespace App\Modules\Equipment\Domain;


use Illuminate\Support\Collection;

class ItemPrototype
{
    /**
     * @var ItemPrototypeId
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
     * @var Collection
     */
    private $effects;
    /**
     * @var ItemPrice
     */
    private $price;

    public function __construct(
        ItemPrototypeId $id,
        string $name,
        string $description,
        string $imageFilePath,
        ItemType $type,
        Collection $effects,
        ItemPrice $price
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->imageFilePath = $imageFilePath;
        $this->type = $type;
        $this->effects = $effects;
        $this->price = $price;
    }

    public function getId(): ItemPrototypeId
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

    public function getEffects(): Collection
    {
        return $this->effects;
    }

    public function getPrice(): ItemPrice
    {
        return $this->price;
    }
}

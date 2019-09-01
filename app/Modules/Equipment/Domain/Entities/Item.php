<?php

namespace App\Modules\Equipment\Domain\Entities;


use App\Modules\Equipment\Domain\ValueObjects\ItemType;
use Illuminate\Support\Collection;

class Item
{
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
     * @var ItemType
     */
    private $type;
    /**
     * @var Collection
     */
    private $effects;
    /**
     * @var string
     */
    private $prototypeId;
    /**
     * @var string
     */
    private $creatorCharacterId;
    /**
     * @var string
     */
    private $ownerCharacterId;
    /**
     * @var string
     */
    private $imageFilePath;

    public function __construct(
        string $id,
        string $name,
        string $description,
        string $imageFilePath,
        ItemType $type,
        Collection $effects,
        string $prototypeId,
        string $creatorCharacterId,
        string $ownerCharacterId
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->imageFilePath = $imageFilePath;
        $this->type = $type;
        $this->effects = $effects;
        $this->prototypeId = $prototypeId;
        $this->creatorCharacterId = $creatorCharacterId;
        $this->ownerCharacterId = $ownerCharacterId;
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

    public function getEffects(): Collection
    {
        return $this->effects;
    }

    public function getPrototypeId(): string
    {
        return $this->prototypeId;
    }

    public function getCreatorCharacterId(): string
    {
        return $this->creatorCharacterId;
    }

    public function getOwnerCharacterId(): string
    {
        return $this->ownerCharacterId;
    }
}

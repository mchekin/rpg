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
    private $title;
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
    private $creatorCharacterId;

    public function __construct(
        string $id,
        string $title,
        string $description,
        ItemType $type,
        Collection $effects,
        string $creatorCharacterId
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->type = $type;
        $this->effects = $effects;
        $this->creatorCharacterId = $creatorCharacterId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getType(): ItemType
    {
        return $this->type;
    }

    public function getEffects(): Collection
    {
        return $this->effects;
    }

    public function getCreatorCharacterId(): string
    {
        return $this->creatorCharacterId;
    }
}
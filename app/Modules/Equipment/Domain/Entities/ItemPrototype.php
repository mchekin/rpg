<?php

namespace App\Modules\Equipment\Domain\Entities;


use App\Modules\Equipment\Domain\ValueObjects\ItemType;
use Illuminate\Support\Collection;

class ItemPrototype
{
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

    public function __construct(string $title, string $description, ItemType $type, Collection $effects)
    {
        $this->title = $title;
        $this->description = $description;
        $this->type = $type;
        $this->effects = $effects;

        // TODO: effects validation
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
}
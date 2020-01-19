<?php

namespace App\Modules\Equipment\Domain\Entities;


use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Equipment\Domain\ValueObjects\InventorySlot;
use App\Modules\Equipment\Domain\ValueObjects\ItemEffect;
use App\Modules\Equipment\Domain\ValueObjects\ItemType;
use Carbon\Carbon;

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
     * @var array
     */
    private $effects;
    /**
     * @var ItemPrototype
     */
    private $prototype;
    /**
     * @var Character
     */
    private $creatorCharacter;
    /**
     * @var Character
     */
    private $ownerCharacter;
    /**
     * @var string
     */
    private $imageFilePath;
    /**
     * @var InventorySlot
     */
    private $inventorySlot;
    /**
     * @var bool
     */
    private $equipped;
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
        array $effects,
        Character $creator,
        ItemPrototype $prototype,
        InventorySlot $inventorySlot
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->imageFilePath = $imageFilePath;
        $this->type = $type;
        $this->setEffects($effects);
        $this->creatorCharacter = $creator;
        $this->ownerCharacter = $creator;
        $this->prototype = $prototype;
        $this->inventorySlot = $inventorySlot;

        $this->equipped = false;
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

    public function getInventorySlot(): InventorySlot
    {
        return $this->inventorySlot;
    }

    public function setInventorySlot(InventorySlot $inventorySlot)
    {
        $this->inventorySlot = $inventorySlot;
    }

    public function isEquipped(): bool
    {
        return $this->equipped;
    }

    public function equip()
    {
        $this->equipped = true;
    }

    public function unEquip()
    {
        $this->equipped = false;
    }

    public function getItemEffect(string $itemEffectType): int
    {
        return (int)array_reduce(
            $this->getEffectsOfType($itemEffectType),
            function ($carry, ItemEffect $itemEffect) use ($itemEffectType) {
                return $carry + $itemEffect->getQuantity();
            }
        );
    }

    private function getEffectsOfType(string $itemEffectType): array
    {
        return array_filter($this->getEffects(), function (ItemEffect $effect) use ($itemEffectType) {
            return $effect->getType() === $itemEffectType;
        });
    }

    public function getPrototype(): ItemPrototype
    {
        return $this->prototype;
    }

    public function getCreatorCharacter(): Character
    {
        return $this->creatorCharacter;
    }

    public function getOwnerCharacter(): Character
    {
        return $this->ownerCharacter;
    }

    public function setEffects(array $effects): void
    {
        $this->effects = array_map(function (ItemEffect $effect) {

            return get_object_vars($effect);

        }, $effects);
    }

    public function getEffects(): array
    {
        return array_map(function (array $effect) {

            return ItemEffect::ofType(
                $effect['quantity'],
                $effect['type']
            );

        }, $this->effects);
    }
}

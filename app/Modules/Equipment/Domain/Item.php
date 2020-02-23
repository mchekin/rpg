<?php

namespace App\Modules\Equipment\Domain;


use App\Modules\Character\Domain\CharacterId;
use Illuminate\Support\Collection;

class Item
{
    /**
     * @var ItemId
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
     * @var ItemPrototypeId
     */
    private $prototypeId;
    /**
     * @var CharacterId
     */
    private $creatorCharacterId;
    /**
     * @var CharacterId
     */
    private $ownerCharacterId;
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

    public function __construct(
        ItemId $id,
        string $name,
        string $description,
        string $imageFilePath,
        ItemType $type,
        Collection $effects,
        ItemPrototypeId $prototypeId,
        CharacterId $creatorCharacterId,
        CharacterId $ownerCharacterId,
        InventorySlot $inventorySlot,
        bool $equipped = false
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
        $this->inventorySlot = $inventorySlot;
        $this->equipped = $equipped;
    }

    public function getId(): ItemId
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

    public function getPrototypeId(): ItemPrototypeId
    {
        return $this->prototypeId;
    }

    public function getCreatorCharacterId(): CharacterId
    {
        return $this->creatorCharacterId;
    }

    public function getOwnerCharacterId(): CharacterId
    {
        return $this->ownerCharacterId;
    }

    public function getInventorySlot(): InventorySlot
    {
        return $this->inventorySlot;
    }

    public function setInventorySlot(InventorySlot $inventorySlot): void
    {
        $this->inventorySlot = $inventorySlot;
    }

    public function isEquipped(): bool
    {
        return $this->equipped;
    }

    public function equip(): void
    {
        $this->equipped = true;
    }

    public function unEquip(): void
    {
        $this->equipped = false;
    }

    public function getItemEffect(string $itemEffectType): int
    {
        return (int)$this->getEffectsOfType($itemEffectType)
            ->reduce(static function ($carry, ItemEffect $itemEffect) {
                return $carry + $itemEffect->getQuantity();
            });
    }

    private function getEffectsOfType(string $itemEffectType): Collection
    {
        return $this->effects->filter(static function (ItemEffect $effect) use ($itemEffectType) {
            return $effect->getType() === $itemEffectType;
        });
    }

    public function equals(Item $otherItem): bool
    {
        return $this->getId()->equals($otherItem->getId());
    }

    public function isOfType(ItemType $type): bool
    {
        return $this->getType()->equals($type);
    }
}

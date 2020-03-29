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
     * @var string
     */
    private $imageFilePath;
    /**
     * @var ItemPrice
     */
    private $price;

    public function __construct(
        ItemId $id,
        string $name,
        string $description,
        string $imageFilePath,
        ItemType $type,
        Collection $effects,
        ItemPrice $price,
        ItemPrototypeId $prototypeId,
        CharacterId $creatorCharacterId
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->imageFilePath = $imageFilePath;
        $this->type = $type;
        $this->effects = $effects;
        $this->price = $price;
        $this->prototypeId = $prototypeId;
        $this->creatorCharacterId = $creatorCharacterId;
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

    public function getPrice(): ItemPrice
    {
        return $this->price;
    }
}

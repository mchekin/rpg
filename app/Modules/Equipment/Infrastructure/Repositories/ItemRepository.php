<?php

namespace App\Modules\Equipment\Infrastructure\Repositories;

use App\Item as ItemModel;
use App\Modules\Equipment\Application\Contracts\ItemRepositoryInterface;
use App\Modules\Equipment\Domain\Entities\Item;
use App\Modules\Equipment\Domain\ValueObjects\ItemEffect;
use App\Modules\Equipment\Infrastructure\ReconstitutionFactories\ItemReconstitutionFactory;

class ItemRepository implements ItemRepositoryInterface
{
    /**
     * @var ItemReconstitutionFactory
     */
    private $reconstitutionFactory;

    public function __construct(ItemReconstitutionFactory $reconstitutionFactory)
    {
        $this->reconstitutionFactory = $reconstitutionFactory;
    }

    public function add(Item $item): void
    {
        $effects = $item->getEffects()->map(static function (ItemEffect $effect) {
            return [
                'quantity' => $effect->getQuantity(),
                'type' => $effect->getType(),
            ];
        })->toJson();

        ItemModel::query()->create([
            'id' => $item->getId(),

            'prototype_id' => $item->getPrototypeId(),
            'creator_character_id' => $item->getCreatorCharacterId(),
            'owner_character_id' => $item->getOwnerCharacterId(),

            'inventory_slot_number' => $item->getInventorySlot()->getSlot(),
            'equipped' => $item->isEquipped(),

            'name' => $item->getName(),
            'description' => $item->getDescription(),

            'effects' => $effects,

            'image_file_path' => $item->getImageFilePath(),

            'type' => $item->getType()->toString(),
        ]);
    }

    public function getOne(string $itemId): Item
    {
        /** @var ItemModel $model */
        $model = ItemModel::query()->findOrFail($itemId);

        return $this->reconstitutionFactory->reconstitute($model);
    }

    public function update(Item $item): void
    {
        $effects = $item->getEffects()->map(static function (ItemEffect $effect) {
            return [
                'quantity' => $effect->getQuantity(),
                'type' => $effect->getType(),
            ];
        })->toJson();

        ItemModel::query()->where('id', $item->getId())->update([
            'prototype_id' => $item->getPrototypeId(),
            'creator_character_id' => $item->getCreatorCharacterId(),
            'owner_character_id' => $item->getOwnerCharacterId(),

            'inventory_slot_number' => $item->getInventorySlot()->getSlot(),
            'equipped' => $item->isEquipped(),

            'name' => $item->getName(),
            'description' => $item->getDescription(),

            'effects' => $effects,

            'image_file_path' => $item->getImageFilePath(),

            'type' => $item->getType()->toString(),
        ]);
    }
}

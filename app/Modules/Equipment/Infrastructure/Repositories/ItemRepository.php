<?php

namespace App\Modules\Equipment\Infrastructure\Repositories;

use App\Item as ItemModel;
use App\Modules\Equipment\Domain\ItemId;
use App\Modules\Equipment\Application\Contracts\ItemRepositoryInterface;
use App\Modules\Equipment\Domain\Item;
use App\Modules\Equipment\Domain\ItemEffect;
use App\Modules\Equipment\Infrastructure\ReconstitutionFactories\ItemReconstitutionFactory;
use App\Traits\GeneratesUuid;
use Exception;

class ItemRepository implements ItemRepositoryInterface
{
    use GeneratesUuid;

    /**
     * @var ItemReconstitutionFactory
     */
    private $reconstitutionFactory;

    public function __construct(ItemReconstitutionFactory $reconstitutionFactory)
    {
        $this->reconstitutionFactory = $reconstitutionFactory;
    }

    /**
     * @return ItemId
     *
     * @throws Exception
     */
    public function nextIdentity(): ItemId
    {
        return ItemId::fromString($this->generateUuid());
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
            'id' => $item->getId()->toString(),

            'prototype_id' => $item->getPrototypeId()->toString(),
            'creator_character_id' => $item->getCreatorCharacterId()->toString(),
            'owner_character_id' => $item->getOwnerCharacterId()->toString(),

            'inventory_slot_number' => $item->getInventorySlot()->getSlot(),
            'equipped' => $item->isEquipped(),

            'name' => $item->getName(),
            'description' => $item->getDescription(),

            'effects' => $effects,

            'image_file_path' => $item->getImageFilePath(),

            'type' => $item->getType()->toString(),
        ]);
    }

    public function getOne(ItemId $itemId): Item
    {
        /** @var ItemModel $model */
        $model = ItemModel::query()->findOrFail($itemId->toString());

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

        ItemModel::query()->where('id', $item->getId()->toString())->update([
            'prototype_id' => $item->getPrototypeId()->toString(),
            'creator_character_id' => $item->getCreatorCharacterId()->toString(),
            'owner_character_id' => $item->getOwnerCharacterId()->toString(),

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

<?php

namespace App\Modules\Equipment\Infrastructure\Repositories;

use App\Item as ItemModel;
use App\Modules\Equipment\Domain\Contracts\ItemRepositoryInterface;
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

    public function add(Item $item)
    {
        $effects = $item->getEffects()->each(function (ItemEffect $effect) {
            return [
                'quantity' => $effect->getQuantity(),
                'type' => $effect->getType(),
            ];
        });

        ItemModel::query()->create([
            'id' => $item->getId(),

            'prototype_id' => $item->getPrototypeId(),
            'creator_id' => $item->getCreatorCharacterId(),
            'owner_id' => $item->getOwnerCharacterId(),

            'name' => $item->getName(),
            'description' => $item->getDescription(),

            'effects' => $effects,

            'image_file_path' => $item->getImageFilePath(),

            'type' => $item->getType()->getType(),
        ]);
    }

    public function getOne(string $itemId): Item
    {
        /** @var ItemModel $model */
        $model = ItemModel::query()->findOrFail($itemId);

        return $this->reconstitutionFactory->reconstitute($model);
    }
}
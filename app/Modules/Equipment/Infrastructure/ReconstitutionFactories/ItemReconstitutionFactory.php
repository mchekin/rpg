<?php


namespace App\Modules\Equipment\Infrastructure\ReconstitutionFactories;

use App\Item as ItemModel;
use App\Modules\Equipment\Domain\Entities\Item;
use App\Modules\Equipment\Domain\ValueObjects\InventorySlot;
use App\Modules\Equipment\Domain\ValueObjects\ItemEffect;
use App\Modules\Equipment\Domain\ValueObjects\ItemType;
use Illuminate\Support\Collection;


class ItemReconstitutionFactory
{
    public function reconstitute(ItemModel $model): Item
    {
        $effects = Collection::make($model->getEffects())->map(function (array $effect) {
                return ItemEffect::ofType(
                    $effect['quantity'],
                    $effect['type']
                );
            });

        $itemPrototype = new Item(
            $model->getId(),
            $model->getName(),
            $model->getDescription(),
            $model->getImageFilePath(),
            ItemType::ofType($model->getType()),
            $effects,
            $model->getPrototypeId(),
            $model->getCreatorCharacterId(),
            $model->getOwnerCharacterId(),
            InventorySlot::defined($model->getInventorySlotNumber())
        );

        return $itemPrototype;
    }
}
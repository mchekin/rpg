<?php


namespace App\Modules\Equipment\Infrastructure\ReconstitutionFactories;

use App\Item as ItemModel;
use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\Item;
use App\Modules\Equipment\Domain\InventorySlot;
use App\Modules\Equipment\Domain\ItemEffect;
use App\Modules\Equipment\Domain\ItemId;
use App\Modules\Equipment\Domain\ItemPrototypeId;
use App\Modules\Equipment\Domain\ItemType;
use Illuminate\Support\Collection;


class ItemReconstitutionFactory
{
    public function reconstitute(ItemModel $model): Item
    {
        $effects = Collection::make($model->getEffects())->map(static function (array $effect) {
            return ItemEffect::ofType(
                $effect['quantity'],
                $effect['type']
            );
        });

        $itemPrototype = new Item(
            ItemId::fromString($model->getId()),
            $model->getName(),
            $model->getDescription(),
            $model->getImageFilePath(),
            ItemType::ofType($model->getType()),
            $effects,
            ItemPrototypeId::fromString($model->getPrototypeId()),
            CharacterId::fromString($model->getCreatorCharacterId()),
            CharacterId::fromString($model->getOwnerCharacterId()),
            InventorySlot::defined($model->getInventorySlotNumber()),
            $model->isEquipped()
        );

        return $itemPrototype;
    }
}

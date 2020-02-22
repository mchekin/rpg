<?php


namespace App\Modules\Equipment\Infrastructure\ReconstitutionFactories;

use App\ItemPrototype as ItemPrototypeModel;
use App\Modules\Equipment\Domain\ItemPrototype;
use App\Modules\Equipment\Domain\ItemEffect;
use App\Modules\Equipment\Domain\ItemType;
use Illuminate\Support\Collection;


class ItemPrototypeReconstitutionFactory
{
    public function reconstitute(ItemPrototypeModel $model): ItemPrototype
    {
        $effects = Collection::make($model->getEffects())->map(static function (array $effect) {
                return ItemEffect::ofType(
                    $effect['quantity'],
                    $effect['type']);
            });

        $itemPrototype = new ItemPrototype(
            $model->getId(),
            $model->getName(),
            $model->getDescription(),
            $model->getImageFilePath(),
            ItemType::ofType($model->getType()),
            $effects
        );

        return $itemPrototype;
    }
}

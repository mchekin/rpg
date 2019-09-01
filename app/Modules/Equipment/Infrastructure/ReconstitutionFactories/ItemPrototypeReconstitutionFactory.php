<?php


namespace App\Modules\Equipment\Infrastructure\ReconstitutionFactories;

use App\ItemPrototype as ItemPrototypeModel;
use App\Modules\Equipment\Domain\Entities\ItemPrototype;
use App\Modules\Equipment\Domain\ValueObjects\ItemEffect;
use App\Modules\Equipment\Domain\ValueObjects\ItemType;
use Illuminate\Support\Collection;


class ItemPrototypeReconstitutionFactory
{
    public function reconstitute(ItemPrototypeModel $model): ItemPrototype
    {
        $effects = Collection::make($model->getEffects())
            ->each(function (array $effect) {
                return ItemEffect::ofType($effect['quantity'], $effect['type']);
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
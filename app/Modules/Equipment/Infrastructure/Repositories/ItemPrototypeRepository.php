<?php

namespace App\Modules\Equipment\Infrastructure\Repositories;

use App\ItemPrototype as ItemPrototypeModel;
use App\Modules\Equipment\Domain\Contracts\ItemPrototypeRepositoryInterface;
use App\Modules\Equipment\Domain\Entities\ItemPrototype;
use App\Modules\Equipment\Infrastructure\ReconstitutionFactories\ItemPrototypeReconstitutionFactory;

class ItemPrototypeRepository implements ItemPrototypeRepositoryInterface
{
    /**
     * @var ItemPrototypeReconstitutionFactory
     */
    private $reconstitutionFactory;

    public function __construct(ItemPrototypeReconstitutionFactory $reconstitutionFactory)
    {
        $this->reconstitutionFactory = $reconstitutionFactory;
    }

    public function getOne(string $itemPrototypeId): ItemPrototype
    {
        /** @var ItemPrototypeModel $model */
        $model = ItemPrototypeModel::query()->findOrFail($itemPrototypeId);

        return $this->reconstitutionFactory->reconstitute($model);
    }
}
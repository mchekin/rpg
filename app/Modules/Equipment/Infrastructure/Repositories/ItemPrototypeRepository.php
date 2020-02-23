<?php

namespace App\Modules\Equipment\Infrastructure\Repositories;

use App\ItemPrototype as ItemPrototypeModel;
use App\Modules\Equipment\Domain\ItemPrototypeId;
use App\Modules\Equipment\Application\Contracts\ItemPrototypeRepositoryInterface;
use App\Modules\Equipment\Domain\ItemPrototype;
use App\Modules\Equipment\Infrastructure\ReconstitutionFactories\ItemPrototypeReconstitutionFactory;
use App\Traits\GeneratesUuid;
use Exception;

class ItemPrototypeRepository implements ItemPrototypeRepositoryInterface
{
    use GeneratesUuid;

    /**
     * @var ItemPrototypeReconstitutionFactory
     */
    private $reconstitutionFactory;

    public function __construct(ItemPrototypeReconstitutionFactory $reconstitutionFactory)
    {
        $this->reconstitutionFactory = $reconstitutionFactory;
    }

    /**
     * @return ItemPrototypeId
     *
     * @throws Exception
     */
    public function nextIdentity(): ItemPrototypeId
    {
        return ItemPrototypeId::fromString($this->generateUuid());
    }

    public function getOne(ItemPrototypeId $itemPrototypeId): ItemPrototype
    {
        /** @var ItemPrototypeModel $model */
        $model = ItemPrototypeModel::query()->findOrFail($itemPrototypeId->toString());

        return $this->reconstitutionFactory->reconstitute($model);
    }
}

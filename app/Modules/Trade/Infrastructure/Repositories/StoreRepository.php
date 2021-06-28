<?php

namespace App\Modules\Trade\Infrastructure\Repositories;

use App\Modules\Trade\Domain\StoreItem;
use App\Modules\Trade\Infrastructure\ReconstitutionFactories\StoreReconstitutionFactory;
use App\Models\Store as StoreModel;
use App\Modules\Character\Domain\CharacterId;
use App\Modules\Trade\Application\Contracts\StoreRepositoryInterface;
use App\Modules\Trade\Domain\Store;
use App\Modules\Trade\Domain\StoreId;
use App\Traits\GeneratesUuid;
use Exception;

class StoreRepository implements StoreRepositoryInterface
{
    use GeneratesUuid;

    /**
     * @var StoreReconstitutionFactory
     */
    private $reconstitutionFactory;

    public function __construct(StoreReconstitutionFactory $reconstitutionFactory)
    {
        $this->reconstitutionFactory = $reconstitutionFactory;
    }

    /**
     * @return StoreId
     *
     * @throws Exception
     */
    public function nextIdentity(): StoreId
    {
        return StoreId::fromString($this->generateUuid());
    }

    public function add(Store $store): void
    {
        StoreModel::query()->create([
            'id' => $store->getId()->toString(),
            'character_id' => $store->getCharacterId()->toString(),
            'money' => $store->getMoney()->getValue(),
        ]);
    }

    public function getOne(StoreId $storeId): Store
    {
        /** @var StoreModel $model */
        $model = StoreModel::query()->findOrFail($storeId->toString());

        return $this->reconstitutionFactory->reconstitute($model);
    }

    public function forCharacter(CharacterId $characterId): Store
    {
        /** @var StoreModel $model */
        $model = StoreModel::query()->where('character_id', $characterId->toString())->firstOrFail();

        return $this->reconstitutionFactory->reconstitute($model);
    }

    public function update(Store $store): void
    {
        /** @var StoreModel $storeModel */
        $storeModel = StoreModel::query()->findOrFail($store->getId()->toString());

        $storeItems = $store->getItems()->mapWithKeys(static function (StoreItem $item, int $slot) {

            $itemId = $item->getId()->toString();

            return [
                $itemId => [
                    'item_id' => $itemId,
                    'price' => $item->getPrice()->getAmount(),
                    'inventory_slot_number' => $slot,
                ],
            ];
        });

        $storeModel->items()->sync($storeItems->all());

        $storeModel->update([
            'money' => $store->getMoney()->getValue(),
        ]);
    }
}

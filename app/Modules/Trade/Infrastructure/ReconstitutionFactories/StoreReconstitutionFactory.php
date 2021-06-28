<?php


namespace App\Modules\Trade\Infrastructure\ReconstitutionFactories;

use App\Models\Item as ItemModel;
use App\Modules\Equipment\Domain\Money;
use App\Modules\Trade\Domain\Store;
use App\Modules\Trade\Domain\StoreId;
use App\Modules\Trade\Domain\StoreType;
use App\Models\Store as StoreModel;
use App\Modules\Character\Domain\CharacterId;

class StoreReconstitutionFactory
{
    /**
     * @var StoreItemReconstitutionFactory
     */
    private $inventoryItemReconstitutionFactory;

    public function __construct(StoreItemReconstitutionFactory $inventoryItemReconstitutionFactory)
    {
        $this->inventoryItemReconstitutionFactory = $inventoryItemReconstitutionFactory;
    }

    public function reconstitute(StoreModel $storeModel): Store
    {
        $items = $storeModel->items->mapWithKeys(function (ItemModel $itemModel) {

            $key = $itemModel->getInventorySlotNumber();
            $inventoryItem = $this->inventoryItemReconstitutionFactory->reconstitute($itemModel);

            return [$key => $inventoryItem];
        });

        return new Store(
            StoreId::fromString($storeModel->getId()),
            CharacterId::fromString($storeModel->getCharacterId()),
            StoreType::ofType($storeModel->getType()),
            $items,
            new Money($storeModel->getMoney())
        );
    }
}

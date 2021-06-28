<?php


namespace App\Modules\Equipment\Infrastructure\ReconstitutionFactories;

use App\Models\Item as ItemModel;
use App\Models\Inventory as InventoryModel;
use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\Inventory;
use App\Modules\Equipment\Domain\InventoryId;
use App\Modules\Equipment\Domain\Money;

class InventoryReconstitutionFactory
{
    /**
     * @var InventoryItemReconstitutionFactory
     */
    private $inventoryItemReconstitutionFactory;

    public function __construct(InventoryItemReconstitutionFactory $inventoryItemReconstitutionFactory)
    {
        $this->inventoryItemReconstitutionFactory = $inventoryItemReconstitutionFactory;
    }

    public function reconstitute(InventoryModel $inventoryModel): Inventory
    {
        $items = $inventoryModel->items->mapWithKeys(function (ItemModel $itemModel) {

            $key = $itemModel->getInventorySlotNumber();
            $inventoryItem = $this->inventoryItemReconstitutionFactory->reconstitute($itemModel);

            return [$key => $inventoryItem];
        });

        return new Inventory(
            InventoryId::fromString($inventoryModel->getId()),
            CharacterId::fromString($inventoryModel->getCharacterId()),
            $items,
            new Money($inventoryModel->getMoney())
        );
    }
}

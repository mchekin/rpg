<?php


namespace App\Modules\Equipment\Infrastructure\ReconstitutionFactories;

use App\Item as ItemModel;
use App\Inventory as InventoryModel;
use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\Inventory;
use App\Modules\Equipment\Domain\InventoryId;

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
        $items = $inventoryModel->items->map(function (ItemModel $itemModel) {
            return $this->inventoryItemReconstitutionFactory->reconstitute($itemModel);
        });

        return new Inventory(
            InventoryId::fromString($inventoryModel->getId()),
            CharacterId::fromString($inventoryModel->getCharacterId()),
            $items
        );
    }
}

<?php


namespace App\Modules\Equipment\Infrastructure\ReconstitutionFactories;

use App\Item as ItemModel;
use App\Modules\Equipment\Domain\InventoryItem;
use App\Modules\Equipment\Domain\ItemStatus;


class InventoryItemReconstitutionFactory
{
    /**
     * @var ItemReconstitutionFactory
     */
    private $itemReconstitutionFactory;

    public function __construct(ItemReconstitutionFactory $itemReconstitutionFactory)
    {
        $this->itemReconstitutionFactory = $itemReconstitutionFactory;
    }

    public function reconstitute(ItemModel $model): InventoryItem
    {
        return new InventoryItem(
            $this->itemReconstitutionFactory->reconstitute($model),
            ItemStatus::ofStatus($model->pivot->status)
        );
    }
}

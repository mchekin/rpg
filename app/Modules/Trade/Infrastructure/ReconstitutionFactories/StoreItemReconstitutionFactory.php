<?php


namespace App\Modules\Trade\Infrastructure\ReconstitutionFactories;

use App\Models\Item as ItemModel;
use App\Modules\Equipment\Domain\ItemPrice;
use App\Modules\Equipment\Infrastructure\ReconstitutionFactories\ItemReconstitutionFactory;
use App\Modules\Trade\Domain\StoreItem;


class StoreItemReconstitutionFactory
{
    /**
     * @var ItemReconstitutionFactory
     */
    private $itemReconstitutionFactory;

    public function __construct(ItemReconstitutionFactory $itemReconstitutionFactory)
    {
        $this->itemReconstitutionFactory = $itemReconstitutionFactory;
    }

    public function reconstitute(ItemModel $model): StoreItem
    {
        return new StoreItem(
            $this->itemReconstitutionFactory->reconstitute($model),
            ItemPrice::ofAmount($model->getPrice())
        );
    }
}

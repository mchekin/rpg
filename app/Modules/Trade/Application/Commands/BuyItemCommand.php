<?php

namespace App\Modules\Trade\Application\Commands;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\ItemId;
use App\Modules\Trade\Domain\StoreId;

class BuyItemCommand
{
    /**
     * @var CharacterId
     */
    private $customerId;
    /**
     * @var StoreId
     */
    private $storeId;
    /**
     * @var ItemId
     */
    private $itemId;

    public function __construct(CharacterId $customerId, StoreId $storeId, ItemId $itemId)
    {
        $this->customerId = $customerId;
        $this->storeId = $storeId;
        $this->itemId = $itemId;
    }

    public function getCustomerId(): CharacterId
    {
        return $this->customerId;
    }

    public function getStoreId(): StoreId
    {
        return $this->storeId;
    }

    public function getItemId(): ItemId
    {
        return $this->itemId;
    }
}

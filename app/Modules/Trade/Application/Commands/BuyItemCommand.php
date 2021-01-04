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
    private $buyerId;
    /**
     * @var StoreId
     */
    private $storeId;
    /**
     * @var ItemId
     */
    private $itemId;

    public function __construct(CharacterId $buyerId, StoreId $storeId, ItemId $itemId)
    {
        $this->buyerId = $buyerId;
        $this->storeId = $storeId;
        $this->itemId = $itemId;
    }

    public function getBuyerId(): CharacterId
    {
        return $this->buyerId;
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

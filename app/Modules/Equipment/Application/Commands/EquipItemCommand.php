<?php

namespace App\Modules\Equipment\Application\Commands;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\ItemId;

class EquipItemCommand
{
    /**
     * @var ItemId
     */
    private $itemId;
    /**
     * @var CharacterId
     */
    private $ownerCharacterId;

    public function __construct(ItemId $itemId, CharacterId $ownerCharacterId)
    {
        $this->itemId = $itemId;
        $this->ownerCharacterId = $ownerCharacterId;
    }

    public function getItemId(): ItemId
    {
        return $this->itemId;
    }

    public function getOwnerCharacterId(): CharacterId
    {
        return $this->ownerCharacterId;
    }
}

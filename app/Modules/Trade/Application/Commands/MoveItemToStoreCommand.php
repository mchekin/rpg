<?php

namespace App\Modules\Trade\Application\Commands;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\ItemId;

class MoveItemToStoreCommand
{
    /**
     * @var ItemId
     */
    private $itemId;
    /**
     * @var CharacterId
     */
    private $characterId;

    public function __construct(ItemId $itemId, CharacterId $characterId)
    {
        $this->itemId = $itemId;
        $this->characterId = $characterId;
    }

    public function getItemId(): ItemId
    {
        return $this->itemId;
    }

    public function getCharacterId(): CharacterId
    {
        return $this->characterId;
    }
}

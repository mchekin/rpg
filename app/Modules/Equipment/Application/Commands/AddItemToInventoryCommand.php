<?php

namespace App\Modules\Equipment\Application\Commands;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\ItemId;

class AddItemToInventoryCommand
{
    /**
     * @var CharacterId
     */
    private $characterId;
    /**
     * @var int
     */
    private $slot;
    /**
     * @var ItemId
     */
    private $itemId;

    public function __construct(CharacterId $characterId, int $slot, ItemId $itemId)
    {
        $this->characterId = $characterId;
        $this->slot = $slot;
        $this->itemId = $itemId;
    }

    public function getCharacterId(): CharacterId
    {
        return $this->characterId;
    }

    public function getSlot(): int
    {
        return $this->slot;
    }

    public function getItemId(): ItemId
    {
        return $this->itemId;
    }
}

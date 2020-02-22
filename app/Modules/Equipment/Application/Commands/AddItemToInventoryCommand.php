<?php

namespace App\Modules\Equipment\Application\Commands;

use App\Modules\Character\Domain\CharacterId;

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
     * @var string
     */
    private $itemId;

    public function __construct(CharacterId $characterId, int $slot, string $itemId)
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

    public function getItemId(): string
    {
        return $this->itemId;
    }
}

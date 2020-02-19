<?php

namespace App\Modules\Equipment\Application\Commands;

class AddItemToInventoryCommand
{
    /**
     * @var string
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

    public function __construct(string $characterId, int $slot, string $itemId)
    {
        $this->characterId = $characterId;
        $this->slot = $slot;
        $this->itemId = $itemId;
    }

    public function getCharacterId(): string
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

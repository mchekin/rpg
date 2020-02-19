<?php

namespace App\Modules\Equipment\Application\Commands;

class EquipItemCommand
{
    /**
     * @var string
     */
    private $itemId;
    /**
     * @var string
     */
    private $ownerCharacterId;

    public function __construct(string $itemId, string $ownerCharacterId)
    {
        $this->itemId = $itemId;
        $this->ownerCharacterId = $ownerCharacterId;
    }

    public function getItemId(): string
    {
        return $this->itemId;
    }

    public function getOwnerCharacterId(): string
    {
        return $this->ownerCharacterId;
    }
}

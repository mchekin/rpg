<?php

namespace App\Modules\Equipment\Application\Commands;

use App\Modules\Character\Domain\CharacterId;

class EquipItemCommand
{
    /**
     * @var string
     */
    private $itemId;
    /**
     * @var CharacterId
     */
    private $ownerCharacterId;

    public function __construct(string $itemId, CharacterId $ownerCharacterId)
    {
        $this->itemId = $itemId;
        $this->ownerCharacterId = $ownerCharacterId;
    }

    public function getItemId(): string
    {
        return $this->itemId;
    }

    public function getOwnerCharacterId(): CharacterId
    {
        return $this->ownerCharacterId;
    }
}

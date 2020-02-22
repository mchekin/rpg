<?php


namespace App\Modules\Character\Application\Commands;


use App\Modules\Character\Domain\CharacterId;

class MoveCharacterCommand
{
    /**
     * @var CharacterId
     */
    private $characterId;

    /**
     * @var string
     */
    private $locationId;

    public function __construct(CharacterId $characterId, string $locationId)
    {
        $this->characterId = $characterId;
        $this->locationId = $locationId;
    }

    public function getCharacterId(): CharacterId
    {
        return $this->characterId;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }
}

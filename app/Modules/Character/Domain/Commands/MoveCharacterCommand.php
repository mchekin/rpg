<?php


namespace App\Modules\Character\Domain\Commands;


class MoveCharacterCommand
{
    /**
     * @var string
     */
    private $characterId;

    /**
     * @var string
     */
    private $locationId;

    public function __construct(string $characterId, string $locationId)
    {
        $this->characterId = $characterId;
        $this->locationId = $locationId;
    }

    public function getCharacterId(): string
    {
        return $this->characterId;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }
}
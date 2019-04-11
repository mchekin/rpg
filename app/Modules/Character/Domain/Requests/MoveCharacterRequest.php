<?php


namespace App\Modules\Character\Domain\Requests;


class MoveCharacterRequest
{
    /**
     * @var string
     */
    private $characterId;

    /**
     * @var int
     */
    private $locationId;

    public function __construct(string $characterId, int $locationId)
    {
        $this->characterId = $characterId;
        $this->locationId = $locationId;
    }

    public function getCharacterId(): string
    {
        return $this->characterId;
    }

    public function getLocationId(): int
    {
        return $this->locationId;
    }
}
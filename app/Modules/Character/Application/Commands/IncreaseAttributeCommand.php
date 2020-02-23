<?php


namespace App\Modules\Character\Application\Commands;


use App\Modules\Character\Domain\CharacterId;

class IncreaseAttributeCommand
{
    /**
     * @var CharacterId
     */
    private $characterId;
    /**
     * @var string
     */
    private $attribute;

    public function __construct(CharacterId $characterId, string $attribute)
    {
        $this->characterId = $characterId;
        $this->attribute = $attribute;
    }

    public function getCharacterId(): CharacterId
    {
        return $this->characterId;
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }
}

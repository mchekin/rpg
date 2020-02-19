<?php


namespace App\Modules\Character\Application\Commands;


class IncreaseAttributeCommand
{
    /**
     * @var string
     */
    private $characterId;
    /**
     * @var string
     */
    private $attribute;

    public function __construct(string $characterId, string $attribute)
    {
        $this->characterId = $characterId;
        $this->attribute = $attribute;
    }

    public function getCharacterId(): string
    {
        return $this->characterId;
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }
}

<?php declare(strict_types=1);


namespace App\Modules\Equipment\Application\Commands;


use App\Modules\Character\Domain\CharacterId;

class CreateInventoryCommand
{
    /**
     * @var CharacterId
     */
    private $characterId;

    public function __construct(CharacterId $characterId)
    {
        $this->characterId = $characterId;
    }

    public function getCharacterId(): CharacterId
    {
        return $this->characterId;
    }
}

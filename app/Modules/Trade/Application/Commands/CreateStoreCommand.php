<?php declare(strict_types=1);


namespace App\Modules\Trade\Application\Commands;


use App\Modules\Character\Domain\CharacterId;

class CreateStoreCommand
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

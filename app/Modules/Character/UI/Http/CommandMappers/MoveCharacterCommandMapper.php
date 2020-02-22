<?php


namespace App\Modules\Character\UI\Http\CommandMappers;

use App\Modules\Character\Application\Commands\MoveCharacterCommand;
use App\Modules\Character\Domain\CharacterId;

class MoveCharacterCommandMapper
{
    public function map(string $characterId, string $locationId): MoveCharacterCommand
    {
        return new MoveCharacterCommand(
            CharacterId::fromString($characterId),
            $locationId
        );
    }
}

<?php


namespace App\Modules\Character\UI\Http\CommandMappers;

use App\Modules\Character\Application\Commands\MoveCharacterCommand;

class MoveCharacterCommandMapper
{
    public function map(string $characterId, string $locationId): MoveCharacterCommand
    {
        return new MoveCharacterCommand(
            $characterId,
            $locationId
        );
    }
}

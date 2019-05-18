<?php


namespace App\Modules\Character\Presentation\Http\CommandMappers;

use App\Modules\Character\Domain\Commands\MoveCharacterCommand;

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
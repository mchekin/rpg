<?php


namespace App\Modules\Character\Presentation\Http\RequestMappers;

use App\Modules\Character\Domain\Requests\MoveCharacterRequest;

class MoveCharacterRequestMapper
{
    public function map(string $characterId, int $locationId): MoveCharacterRequest
    {
        return new MoveCharacterRequest(
            $characterId,
            $locationId
        );
    }
}
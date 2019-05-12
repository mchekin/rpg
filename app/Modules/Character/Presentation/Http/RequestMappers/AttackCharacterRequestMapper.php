<?php


namespace App\Modules\Character\Presentation\Http\RequestMappers;

use App\Modules\Character\Domain\Requests\AttackCharacterRequest;

class AttackCharacterRequestMapper
{
    public function map(string $attackerId, string $defenderId): AttackCharacterRequest
    {
        return new AttackCharacterRequest($attackerId, $defenderId);
    }
}
<?php


namespace App\Modules\Character\UI\Http\CommandMappers;

use App\Modules\Character\Application\Commands\IncreaseAttributeCommand;
use App\Modules\Character\Domain\CharacterId;
use Illuminate\Http\Request;

class IncreaseAttributeCommandMapper
{
    public function map(string $characterId, Request $request): IncreaseAttributeCommand
    {
        return new IncreaseAttributeCommand(
            CharacterId::fromString($characterId),
            $request->input('attribute')
        );
    }
}

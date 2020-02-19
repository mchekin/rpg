<?php


namespace App\Modules\Character\UI\Http\CommandMappers;

use App\Modules\Character\Application\Commands\IncreaseAttributeCommand;
use Illuminate\Http\Request;

class IncreaseAttributeCommandMapper
{
    public function map(string $characterId, Request $request): IncreaseAttributeCommand
    {
        return new IncreaseAttributeCommand(
            $characterId,
            $request->input('attribute')
        );
    }
}

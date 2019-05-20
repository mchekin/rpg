<?php


namespace App\Modules\Character\Presentation\Http\CommandMappers;

use App\Modules\Character\Domain\Commands\IncreaseAttributeCommand;
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
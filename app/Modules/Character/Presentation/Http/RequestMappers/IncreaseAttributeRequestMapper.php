<?php


namespace App\Modules\Character\Presentation\Http\RequestMappers;

use App\Modules\Character\Domain\Requests\IncreaseAttributeRequest;
use Illuminate\Http\Request;

class IncreaseAttributeRequestMapper
{
    public function map(string $characterId, Request $request): IncreaseAttributeRequest
    {
        return new IncreaseAttributeRequest(
            $characterId,
            $request->input('attribute')
        );
    }
}
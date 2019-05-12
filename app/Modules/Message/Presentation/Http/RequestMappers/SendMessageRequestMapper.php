<?php


namespace App\Modules\Message\Presentation\Http\RequestMappers;

use App\Character;
use App\Modules\Message\Domain\Requests\SendMessageRequest;
use Illuminate\Http\Request;

class SendMessageRequestMapper
{
    public function map(Request $request): SendMessageRequest
    {
        /** @var Character $currentCharacter */
        $user = $request->user();
        $currentCharacter = $user->character;

        return new SendMessageRequest(
            $currentCharacter->id,
            (string)$request->route('character')->id,
            (string)$request->get('content')
        );
    }
}
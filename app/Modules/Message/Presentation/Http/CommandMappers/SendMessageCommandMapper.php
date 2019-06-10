<?php


namespace App\Modules\Message\Presentation\Http\CommandMappers;

use App\Character;
use App\Modules\Message\Domain\Commands\SendMessageCommand;
use Illuminate\Http\Request;

class SendMessageCommandMapper
{
    public function map(Request $request): SendMessageCommand
    {
        /** @var Character $currentCharacter */
        $user = $request->user();
        $currentCharacter = $user->character;

        return new SendMessageCommand(
            $currentCharacter->id,
            (string)$request->route('character'),
            (string)$request->get('content')
        );
    }
}
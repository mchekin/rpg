<?php


namespace App\Modules\Message\UI\Http\CommandMappers;

use App\Models\Character;
use App\Modules\Character\Domain\CharacterId;
use App\Modules\Message\Application\Commands\SendMessageCommand;
use Illuminate\Http\Request;

class SendMessageCommandMapper
{
    public function map(Request $request): SendMessageCommand
    {
        /** @var Character $currentCharacter */
        $user = $request->user();
        $currentCharacter = $user->character;

        return new SendMessageCommand(
            CharacterId::fromString($currentCharacter->id),
            CharacterId::fromString((string)$request->route('character')),
            (string)$request->get('content')
        );
    }
}

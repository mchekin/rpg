<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Modules\Message\Application\Services\MessageService;
use App\Modules\Message\UI\Http\CommandMappers\SendMessageCommandMapper;
use Illuminate\Http\Request;

class CharacterMessageController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'has.character']);
    }

    public function index(string $characterId)
    {
        $character = Character::query()->findOrFail($characterId);

        return view('character.message.index', compact('character'));
    }

    public function store(
        string $characterId,
        Request $request,
        SendMessageCommandMapper $commandMapper,
        MessageService $messageService
    ) {
        $sendMessageCommand = $commandMapper->map($request);

        $messageService->send($sendMessageCommand);

        return redirect()->route('character.message.index', $characterId);
    }
}

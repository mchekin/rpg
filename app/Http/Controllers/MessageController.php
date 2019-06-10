<?php

namespace App\Http\Controllers;

use App\Character;
use App\Modules\Message\Domain\Services\MessageService;
use App\Modules\Message\Presentation\Http\CommandMappers\SendMessageCommandMapper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'has.character']);
    }

    /**
     * @return Response
     */
    public function inbox()
    {
        return view('message.inbox');
    }

    /**
     * @return Response
     */
    public function sent()
    {
        return view('message.sent');
    }

    public function index(string $characterId)
    {
        $character = Character::query()->findOrFail($characterId);

        return view('message.index', compact('character'));
    }

    public function store(
        string $characterId,
        Request $request,
        SendMessageCommandMapper $commandMapper,
        MessageService $messageService
    ) {
        $sendMessageCommand = $commandMapper->map($request);

        $messageService->send($sendMessageCommand);

        return redirect()->route("character.message.index", $characterId);
    }
}

<?php

namespace App\Http\Controllers;

use App\Character;
use App\Modules\Message\Domain\Services\MessageService;
use App\Modules\Message\Presentation\Http\RequestMappers\SendMessageRequestMapper;
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

    /**
     * Show the form for creating a new resource.
     *
     * @param Character $character
     *
     * @return Response
     */
    public function index(Character $character)
    {

        return view('message.index', compact('character'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Character $character
     * @param Request $request
     * @param SendMessageRequestMapper $requestMapper
     * @param MessageService $messageService
     *
     * @return Response
     */
    public function store(
        Character $character,
        Request $request,
        SendMessageRequestMapper $requestMapper,
        MessageService $messageService
    ) {
        $sendRequest = $requestMapper->map($request);

        $messageService->send($sendRequest);

        return redirect()->route("character.message.index", compact('character'));
    }
}

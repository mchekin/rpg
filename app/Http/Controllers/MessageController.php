<?php

namespace App\Http\Controllers;

use App\Character;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inani\Messager\Message;

class MessageController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'has.character']);
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
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $currentUserCharacter = $currentUser->character;

        return view('message.index', compact('character', 'currentUserCharacter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Character $character
     * @param Request $request
     *
     * @return Response
     */
    public function store(Character $character, Request $request)
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        $content = $request->get('content');

        $message = new Message(compact('content'));

        $currentUser->writes($message)->to($character->user)->send();

        return redirect()->route("character.message.index", compact('character'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Character;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
     *
     * @return Response
     */
    public function store(Character $character, Request $request)
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        $currentUser->sendMessageTo($character->user, $request->get('content'));

        return redirect()->route("character.message.index", compact('character'));
    }
}

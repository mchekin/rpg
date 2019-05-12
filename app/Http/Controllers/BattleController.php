<?php

namespace App\Http\Controllers;

use App\Battle;

class BattleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['show']]);
        $this->middleware('has.character', ['only' => ['show']]);
    }

    public function show(Battle $battle)
    {
        return view('battle.show', compact('battle'));
    }
}

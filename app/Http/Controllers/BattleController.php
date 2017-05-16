<?php

namespace App\Http\Controllers;

use App\Battle;
use Illuminate\Http\Request;

class BattleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['show']]);
        $this->middleware('has.character', ['only' => ['show']]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Battle  $battle
     * @return \Illuminate\Http\Response
     */
    public function show(Battle $battle)
    {
        return view('battle.show', compact('battle'));
    }
}

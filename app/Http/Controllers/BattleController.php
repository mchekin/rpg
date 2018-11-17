<?php

namespace App\Http\Controllers;

use App\Battle;
use App\Contracts\Models\BattleInterface;
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
     * @param  BattleInterface $battle
     * @return \Illuminate\Http\Response
     */
    public function show(BattleInterface $battle)
    {
        return view('battle.show', compact('battle'));
    }
}

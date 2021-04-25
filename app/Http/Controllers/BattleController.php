<?php

namespace App\Http\Controllers;

use App\Models\Battle;

class BattleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['show']]);
        $this->middleware('has.character', ['only' => ['show']]);
    }

    public function show(string $battleId)
    {
        $battle = Battle::query()->findOrFail($battleId);

        return view('battle.show', compact('battle'));
    }
}

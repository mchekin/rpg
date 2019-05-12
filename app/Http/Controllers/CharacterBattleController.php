<?php

namespace App\Http\Controllers;

use App\Character;

class CharacterBattleController extends Controller
{
    public function index(Character $character)
    {
        return view('character.battle.index', compact('character'));
    }
}

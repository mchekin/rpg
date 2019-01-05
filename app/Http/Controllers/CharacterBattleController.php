<?php

namespace App\Http\Controllers;

use App\Contracts\Models\CharacterInterface;

class CharacterBattleController extends Controller
{
    public function index(CharacterInterface $character)
    {
        return view('character.battle.index', compact('character'));
    }
}

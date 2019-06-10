<?php

namespace App\Http\Controllers;

use App\Character;

class CharacterBattleController extends Controller
{
    public function index(string $characterId)
    {
        $character = Character::query()->findOrFail($characterId);

        return view('character.battle.index', compact('character'));
    }
}

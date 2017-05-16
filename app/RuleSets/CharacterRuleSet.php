<?php

namespace App\RuleSets;


use App\Battle;
use App\BattleRound;
use App\BattleTurn;
use App\Character;
use App\Race;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CharacterRuleSet
{
    public function createCharacter(Request $request)
    {
        /** @var User $authenticatedUser */
        $authenticatedUser = $request->user();

        /** @var Race $race */
        $race = Race::query()->findOrFail($request->input('race_id'));

        $totalHitPoints = $race->constitution * 10 + rand(10,20);

        $character = $authenticatedUser->character()->create([
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),

            'xp' => 0,
            'level' => 1,
            'money' => 0,
            'reputation' => 0,

            'strength' => $race->strength,
            'agility' => $race->agility,
            'constitution' => $race->constitution,
            'intelligence' => $race->intelligence,
            'charisma' => $race->charisma,

            'hit_points' => $totalHitPoints,
            'total_hit_points' => $totalHitPoints,

            'race_id' => $race->id,
            'location_id' => $race->starting_location_id,
        ]);
    }
}
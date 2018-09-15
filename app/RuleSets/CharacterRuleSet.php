<?php

namespace App\RuleSets;

use App\Character;
use App\Race;
use App\User;
use Illuminate\Http\Request;

class CharacterRuleSet
{
    /**
     * @param Request $request
     * @return Character
     */
    public function createCharacter(Request $request)
    {
        /** @var User $authenticatedUser */
        $authenticatedUser = $request->user();

        /** @var Race $race */
        $race = Race::query()->findOrFail($request->input('race_id'));

        $totalHitPoints = $this->calculateHP($race->constitution);

        /** @var Character $character */
        $character = $authenticatedUser->character()->create([
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),

            'xp' => 0,
            'level_id' => 1,
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

        return $character;
    }
    /**
     * @return int
     */
    protected function throwTwoDices(): int
    {
        return $this->throwOneDice() + $this->throwOneDice();
    }

    /**
     * @return int
     */
    protected function throwOneDice(): int
    {
        return rand(1, 6);
    }

    /**
     * @param int $constitution
     * @return int
     */
    protected function calculateHP(int $constitution): int
    {
        return $constitution * 10 + $this->throwTwoDices();
    }
}
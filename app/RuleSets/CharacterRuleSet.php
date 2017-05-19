<?php

namespace App\RuleSets;


use App\Battle;
use App\BattleRound;
use App\BattleTurn;
use App\Character;
use App\Level;
use App\Race;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $totalHitPoints = $race->constitution * 10 + $this->throwTwoDices();

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
     * @param Character $attacker
     * @param Character $defender
     * @return Battle
     */
    public function attack(Character $attacker, Character $defender)
    {
        $battle = DB::transaction(function () use ($defender, $attacker) {

            $attackerXpGained = 0;
            $defenderXpGained = 0;

            /** @var Battle $battle */
            $battle = Battle::query()->create([
                'attacker_id' => $attacker->id,
                'defender_id' => $defender->id,
                'location_id' => $defender->location->id,
            ]);

            while ($defender->hit_points > 0 && $attacker->hit_points > 0) {
                /** @var BattleRound $currentRound */
                $currentRound = $battle->rounds()->create([]);

                $attackerXpGained += $this->performTurn($currentRound, $attacker, $defender);

                if ($defender->hit_points < 1) {
                    $attacker->battles_won++;
                    $defender->battles_lost++;
                    break;
                }

                $defenderXpGained += $this->performTurn($currentRound, $defender, $attacker);

                if ($attacker->hit_points < 1) {
                    $defender->battles_won++;
                    $attacker->battles_lost++;
                    break;
                }
            }

            // set victor
            $victor = ($attacker->hit_points > 0) ? $attacker : $defender;
            $battle->victor()->associate($victor)->save();

            $attacker->xp += $attackerXpGained;
            $this->checkLevelUp($attacker);
            $attacker->save();

            $defender->xp += $defenderXpGained;
            $this->checkLevelUp($defender);
            $defender->save();

            return $battle;
        });

        return $battle;
    }

    /**
     * @param BattleRound $currentRound
     * @param Character $executor
     * @param Character $target
     *
     * @return mixed
     */
    protected function performTurn(BattleRound $currentRound, Character $executor, Character $target)
    {
        $damageDone = 0;
        $executorXpGained = 0;

        $attackForce = $this->throwOneDice() + $executor->strength;
        $attackFactor = $this->throwOneDice() + $executor->agility;
        $defenceFactor = $this->throwOneDice() + $target->agility;

        if ($attackFactor > $defenceFactor) {
            $damageDone = $attackForce;
            $target->hit_points -= $damageDone;
            $executorXpGained = $target->level->id;
        }

        $currentRound->turns()->create([
            'damage' => $damageDone,
            'executor_id' => $executor->id,
            'target_id' => $target->id,
        ]);

        return $executorXpGained;
    }

    /**
     * @param Character $character
     * @return $this
     */
    protected function checkLevelUp(Character $character)
    {
        while ($this->shouldLevelUp($character, $nextLevel = $character->level->nextLevel())) {

            // update character's level
            $character->level()->associate($nextLevel);

            // add attribute points
            $character->available_attribute_points++;
        }

        return $this;
    }

    /**
     * @param Character $character
     * @param Level $nextLevel
     * @return bool
     */
    protected function shouldLevelUp(Character $character, $nextLevel)
    {
        return !is_null($nextLevel) && ($character->xp > $character->level->next_level_xp_threshold);
    }

    /**
     * @return int
     */
    protected function throwTwoDices()
    {
        return $this->throwOneDice() + $this->throwOneDice();
    }

    /**
     * @return int
     */
    protected function throwOneDice()
    {
        return rand(1, 6);
    }
}
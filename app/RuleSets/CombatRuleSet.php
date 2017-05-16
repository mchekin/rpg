<?php

namespace App\RuleSets;


use App\Battle;
use App\BattleRound;
use App\BattleTurn;
use App\Character;
use Illuminate\Support\Facades\DB;

class CombatRuleSet
{

    /**
     * @param Character $attacker
     * @param Character $defender
     * @return Battle
     */
    public function attack(Character $attacker, Character $defender)
    {
        $battle = DB::transaction(function () use ($defender, $attacker) {
            /** @var Battle $battle */
            $battle = Battle::query()->create([
                'attacker_id' => $attacker->id,
                'defender_id' => $defender->id,
                'location_id' => $defender->location->id,
            ]);

            while ($defender->hit_points > 0 && $attacker->hit_points > 0) {

                /** @var BattleRound $currentRound */
                $currentRound = $battle->rounds()->create([]);

                $attackerDamage = rand(1, 10);
                $currentRound->turns()->create([
                    'damage' => $attackerDamage,
                    'executor_id' => $attacker->id,
                    'target_id' => $defender->id,
                ]);
                if ($attackerDamage > 0) {
                    $defender->hit_points -= $attackerDamage;
                }

                if ($defender->hit_points < 1) {
                    break;
                }

                $defenderDamage = rand(1, 10);
                $currentRound->turns()->create([
                    'damage' => $defenderDamage,
                    'executor_id' => $defender->id,
                    'target_id' => $attacker->id,
                ]);
                if ($defenderDamage > 0) {
                    $attacker->hit_points -= $defenderDamage;
                }
            }

            // set victor
            $victor = ($attacker->hit_points > 0) ? $attacker : $defender;
            $battle->victor()->associate($victor)->save();

            $attacker->save();
            $defender->save();

            return $battle;
        });

        return $battle;
    }
}
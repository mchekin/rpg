<?php

namespace App;

use App\Contracts\Models\BattleRoundInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BattleRound extends Model implements BattleRoundInterface
{
    /**
     * @return HasMany
     */
    public function turns()
    {
        return $this->hasMany(BattleTurn::class);
    }

    /**
     * @param Character $executor
     * @param Character $target
     *
     * @return BattleRoundInterface
     */
    public function performTurn(Character $executor, Character $target)
    {
        $attackForce = $this->throwOneDice() + $executor->strength;
        $attackFactor = $this->throwOneDice() + $executor->agility;
        $defenceFactor = $this->throwOneDice() + $target->agility;

        if ($attackFactor > $defenceFactor) {
            $damageDone = $attackForce;
            $target->hit_points -= $damageDone;
        }

        $this->turns()->create([
            'damage' => $damageDone ?? 0,
            'executor_id' => $executor->id,
            'target_id' => $target->id,
        ]);

        return $this;
    }

    /**
     * @return int
     */
    protected function throwOneDice(): int
    {
        return rand(1, 6);
    }
}

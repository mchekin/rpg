<?php

namespace App;

use App\Contracts\Models\BattleRoundInterface;
use App\Contracts\Models\CharacterInterface;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BattleRound extends BaseModel implements BattleRoundInterface
{
    /**
     * @return HasMany
     */
    public function turns()
    {
        return $this->hasMany(BattleTurn::class);
    }

    public function performTurn(CharacterInterface $executor, CharacterInterface $target): BattleRoundInterface
    {
        $attackForce = $this->throwOneDice() + $executor->getStrength();
        $attackFactor = $this->throwOneDice() + $executor->getAgility();
        $defenceFactor = $this->throwOneDice() + $target->getAgility();

        if ($attackFactor > $defenceFactor) {
            $damageDone = $attackForce;
            $target->applyDamage($damageDone);
        }

        $this->turns()->create([
            'damage' => $damageDone ?? 0,
            'executor_id' => $executor->getId(),
            'target_id' => $target->getId(),
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

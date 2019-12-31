<?php


namespace App\Modules\Battle\Domain\Factories;


use App\Modules\Battle\Domain\Entities\BattleRound;
use App\Modules\Battle\Domain\Entities\Collections\BattleTurns;
use App\Modules\Character\Domain\Entities\Character;
use App\Traits\GeneratesUuid;

class BattleRoundFactory
{
    use GeneratesUuid;

    public function create(string $battleId, Character $attacker, Character $defender): BattleRound
    {
        return new BattleRound(
            $this->generateUuid(),
            $battleId,
            $attacker,
            $defender,
            new BattleTurns()
        );
    }
}

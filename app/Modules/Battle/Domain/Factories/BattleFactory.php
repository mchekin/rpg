<?php


namespace App\Modules\Battle\Domain\Factories;


use App\Modules\Battle\Domain\Entities\Battle;
use App\Modules\Battle\Domain\Entities\Collections\BattleRounds;
use App\Modules\Character\Domain\Entities\Character;
use App\Traits\GeneratesUuid;

class BattleFactory
{
    use GeneratesUuid;

    public function create(Character $attacker, Character $defender): Battle
    {
        return new Battle(
            $this->generateUuid(),
            $defender->getLocation(),
            $attacker,
            $defender,
            new BattleRounds(),
            0
        );
    }
}

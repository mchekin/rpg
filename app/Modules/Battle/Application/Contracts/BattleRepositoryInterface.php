<?php

namespace App\Modules\Battle\Application\Contracts;

use App\Modules\Battle\Domain\Battle;
use App\Modules\Battle\Domain\BattleId;

interface BattleRepositoryInterface
{
    public function nextIdentity(): BattleId;

    public function add(Battle $battle):void;
}

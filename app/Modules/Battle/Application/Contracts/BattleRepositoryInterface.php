<?php

namespace App\Modules\Battle\Application\Contracts;

use App\Modules\Battle\Domain\Battle;

interface BattleRepositoryInterface
{
    public function add(Battle $battle):void;
}

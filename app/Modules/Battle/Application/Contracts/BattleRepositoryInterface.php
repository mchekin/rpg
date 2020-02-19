<?php

namespace App\Modules\Battle\Application\Contracts;

use App\Modules\Battle\Domain\Entities\Battle;

interface BattleRepositoryInterface
{
    public function add(Battle $battle):void;
}

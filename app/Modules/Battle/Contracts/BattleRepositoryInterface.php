<?php

namespace App\Modules\Battle\Domain\Contracts;

use App\Modules\Battle\Domain\Entities\Battle;

interface BattleRepositoryInterface
{
    public function add(Battle $battle);

    public function getOne(string $battleId): Battle;
}
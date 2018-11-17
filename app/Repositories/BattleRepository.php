<?php

namespace App\Repositories;

use App\Character;
use App\Contracts\Models\BattleInterface;
use App\Contracts\Repositories\BattleRepositoryInterface;

class BattleRepository implements BattleRepositoryInterface
{
    public function save(BattleInterface $battle): BattleInterface
    {
        /** @var $battle Character **/
        $battle->save();

        return $battle;
    }
}
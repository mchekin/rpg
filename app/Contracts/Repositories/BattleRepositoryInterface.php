<?php

namespace App\Contracts\Repositories;


use App\Contracts\Models\BattleInterface;

interface BattleRepositoryInterface
{
    public function save(BattleInterface $battle): BattleInterface;
}
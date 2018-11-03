<?php

namespace App\Contracts\Models;

use App\Character;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface BattleRoundInterface
{
    /**
     * @return HasMany
     */
    public function turns();

    /**
     * @param Character $executor
     * @param Character $target
     *
     * @return BattleRoundInterface
     */
    public function performTurn(Character $executor, Character $target);
}
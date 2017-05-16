<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BattleRound extends Model
{
    /**
     * @return HasMany
     */
    public function turns()
    {
        return $this->hasMany(BattleTurn::class);
    }
}

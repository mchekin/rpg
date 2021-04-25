<?php

namespace App\Models;

use App\Traits\UsesStringId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BattleRound extends Model
{
    use UsesStringId;

    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function turns()
    {
        return $this->hasMany(BattleTurn::class);
    }
}

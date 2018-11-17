<?php

namespace App\Contracts\Models;

use App\Character;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property Collection rounds
 * @property Character attacker
 * @property Character defender
 * @property int victor_xp_gained
 */
interface BattleInterface
{
    /**
     * @return $this
     */
    public function execute(): BattleInterface;
}
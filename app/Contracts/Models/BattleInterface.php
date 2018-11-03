<?php

namespace App\Contracts\Models;

use App\Character;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection rounds
 * @property Character attacker
 * @property Character defender
 * @property int victor_xp_gained
 */
interface BattleInterface
{
    /**
     * @return HasMany
     */
    public function rounds();

    /**
     * @return BelongsTo
     */
    public function attacker();

    /**
     * @return BelongsTo
     */
    public function defender();

    /**
     * @return BelongsTo
     */
    public function victor();

    /**
     * Get the location of the battle
     *
     * @return BelongsTo
     */
    public function location();

    /**
     * @return $this
     */
    public function execute(): BattleInterface;
}
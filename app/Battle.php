<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection rounds
 */
class Battle extends Model
{
    protected $fillable = [
        'attacker_id',
        'defender_id',
        'location_id',
    ];

    /**
     * @return HasMany
     */
    public function rounds()
    {
        return $this->hasMany(BattleRound::class);
    }

    /**
     * @return BelongsTo
     */
    public function attacker()
    {
        return $this->belongsTo(Character::class, 'attacker_id');
    }

    /**
     * @return BelongsTo
     */
    public function defender()
    {
        return $this->belongsTo(Character::class, 'defender_id');
    }

    /**
     * @return BelongsTo
     */
    public function victor()
    {
        return $this->belongsTo(Character::class, 'victor_id');
    }

    /**
     * Get the location of the battle
     *
     * @return BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}

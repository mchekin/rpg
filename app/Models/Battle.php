<?php

namespace App\Models;

use App\Traits\UsesStringId;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection rounds
 * @property Character attacker
 * @property Character defender
 * @property int victor_xp_gained
 * @property Location location
 * @property Character victor
 */
class Battle extends Model
{
    use UsesStringId;

    protected $guarded = [];

    public function rounds(): HasMany
    {
        return $this->hasMany(BattleRound::class);
    }

    public function attacker(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'attacker_id');
    }

    public function defender(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'defender_id');
    }

    public function victor(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'victor_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeUnseenByDefender($query)
    {
        return $query->where('seen_by_defender', false);
    }

    /**
     * Read the selected Messages
     *
     * @param $query
     * @return mixed
     */
    public function scopeMarkAsSeenByDefender($query)
    {
        return $query->update(['seen_by_defender' => true]);
    }

    public function getAttacker(): Character
    {
        return $this->attacker;
    }

    public function getDefender(): Character
    {
        return $this->defender;
    }

    public function isTheVictor(Character $character): bool
    {
        return $this->victor->id ===  $character->getId();
    }
}

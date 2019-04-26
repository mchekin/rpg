<?php

namespace App;

use App\Traits\UsesStringId;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

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

    /**
     * Boot the Model.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($instance) {
            $instance->id = Uuid::uuid4();
        });
    }

    protected $guarded = [];

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

    protected function calculateVictorXpGained(Character $loser, Character $victor): int
    {
        $this->victor_xp_gained = max($loser->getLevelNumber() - $victor->getLevelNumber(), 1) * 10;

        return $this->victor_xp_gained;
    }

    public function getAttacker(): Character
    {
        return $this->attacker;
    }

    public function getDefender(): Character
    {
        return $this->defender;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function isTheVictor(Character $character): bool
    {
        return $this->victor->id ===  $character->getId();
    }
}

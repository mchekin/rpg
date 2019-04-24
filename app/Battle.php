<?php

namespace App;

use App\Contracts\Models\BattleInterface;
use App\Contracts\Models\BattleRoundInterface;
use App\Contracts\Models\CharacterInterface;
use App\Contracts\Models\LocationInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

/**
 * @property Collection rounds
 * @property CharacterInterface attacker
 * @property CharacterInterface defender
 * @property int victor_xp_gained
 * @property LocationInterface location
 * @property CharacterInterface victor
 */
class Battle extends Model implements BattleInterface
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

    /**
     * @return BattleInterface
     */
    public function execute(): BattleInterface
    {
        while ($this->attacker->isAlive()) {
            /** @var BattleRoundInterface $currentRound */
            $currentRound = $this->rounds()->create([]);

            $currentRound->performTurn($this->attacker, $this->defender);

            if (!$this->defender->isAlive()) {
                break;
            }

            $currentRound->performTurn($this->defender, $this->attacker);
        }

        $victor = $this->attacker->isAlive() ? $this->attacker : $this->defender;
        $loser = $this->attacker->isAlive() ? $this->defender : $this->attacker;

        $victor->incrementWonBattles();
        $loser->incrementLostBattles();

        $victor->addXp($this->calculateVictorXpGained($loser, $victor));

        $this->victor()->associate($victor);

        return $this;
    }

    protected function calculateVictorXpGained(CharacterInterface $loser, CharacterInterface $victor): int
    {
        $this->victor_xp_gained = max($loser->getLevelNumber() - $victor->getLevelNumber(), 1) * 10;

        return $this->victor_xp_gained;
    }

    public function getAttacker(): CharacterInterface
    {
        return $this->attacker;
    }

    public function getDefender(): CharacterInterface
    {
        return $this->defender;
    }

    public function getLocation(): LocationInterface
    {
        return $this->location;
    }

    public function isTheVictor(CharacterInterface $character): bool
    {
        return $this->victor->id ===  $character->getId();
    }
}

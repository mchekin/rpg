<?php

namespace App;

use App\Contracts\Models\BattleInterface;
use App\Contracts\Models\BattleRoundInterface;
use App\Contracts\Models\CharacterInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection rounds
 * @property CharacterInterface attacker
 * @property CharacterInterface defender
 * @property int victor_xp_gained
 */
class Battle extends Model implements BattleInterface
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

    /**
     * @return BattleInterface
     */
    public function execute(): BattleInterface
    {
        while ($this->attacker->isAlive() && $this->defender->isAlive()) {
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
}

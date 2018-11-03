<?php

namespace App;

use App\Contracts\Models\BattleInterface;
use App\Contracts\Models\BattleRoundInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection rounds
 * @property Character attacker
 * @property Character defender
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
        while ($this->attacker->hit_points > 0 && $this->defender->hit_points > 0 ) {
            /** @var BattleRoundInterface $currentRound */
            $currentRound = $this->rounds()->create([]);

            $currentRound->performTurn($this->attacker, $this->defender);

            if ($this->defender->hit_points < 1) {
                break;
            }

            $currentRound->performTurn($this->defender, $this->attacker);
        }

        /** @var Character $victor */
        /** @var Character $loser */
        list($victor, $loser) = ($this->attacker->hit_points > 0)
            ? [$this->attacker, $this->defender]
            : [$this->defender, $this->attacker];

        $victor->battles_won++;
        $loser->battles_lost++;

        $this->victor_xp_gained = (max($loser->level->id - $victor->level->id, 0) + 1) * 10;
        $victor->xp += $this->victor_xp_gained;
        $victor->checkLevelUp();

        $victor->save();
        $loser->save();
        $this->victor()->associate($victor)->save();

        return $this;
    }
}

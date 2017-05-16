<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer strength
 * @property integer agility
 * @property integer constitution
 * @property integer intelligence
 * @property integer charisma
 * @property integer starting_location_id
 * @property integer id
 */
class Race extends Model
{
    /**
     * Get the characters for the race.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characters()
    {
        return $this->hasMany(Character::class);
    }
}

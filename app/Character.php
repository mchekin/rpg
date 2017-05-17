<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property User user
 * @property Location location
 * @property integer id
 * @property integer hit_points
 * @property integer xp
 * @property Level level
 * @property integer available_attribute_points
 */
class Character extends Model
{

    protected $guarded = ['user_id'];

    /**
     * Get the user of the character
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Get the user of the character
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Check if the character is an Non Player Character ( user_id field is null )
     *
     * @return bool
     */
    public function isNPC()
    {
        return is_null($this->user);
    }

    /**
     * Get the user of the character
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    /**
     * Get the current location of the character
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}

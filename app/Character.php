<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $guarded = ['user_id'];
    /**
     * Get the user of the character
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    /**
     * Check if the character is an Non Player Character ( user field is null )
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
        return $this->belongsTo('App\Race');
    }

    /**
     * Get the current location of the character
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}

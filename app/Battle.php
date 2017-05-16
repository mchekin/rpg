<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Battle extends Model
{
    protected $guarded = [

    ];
    /**
     * @return BelongsToMany
     */
    public function attacker()
    {
        return $this->belongsTo(Character::class, 'attacker_id');
    }
    /**
     * @return BelongsToMany
     */
    public function defender()
    {
        return $this->belongsTo(Character::class, 'defender_id');
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

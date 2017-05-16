<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BattleTurn extends Model
{
    protected $fillable = [
        'damage',
        'executor_id',
        'target_id',
    ];

    /**
     * @return BelongsTo
     */
    public function executor()
    {
        return $this->belongsTo(Character::class, 'executor_id');
    }
    /**
     * @return BelongsTo
     */
    public function target()
    {
        return $this->belongsTo(Character::class, 'target_id');
    }
}

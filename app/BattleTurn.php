<?php

namespace App;

use App\Traits\UsesStringId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class BattleTurn extends Model
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

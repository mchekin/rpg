<?php

namespace App;

use App\Traits\UsesStringId;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property Character character
 * @property Collection items
 * @property string id
 * @property string character_id
 * @property int money
 */
class Inventory extends Model
{
    use UsesStringId;

    protected $casts = [
        'money' => 'integer',
    ];

    protected $guarded = [];

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'character_id');
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->withPivot('inventory_slot_number', 'status');
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCharacterId(): string
    {
        return $this->character_id;
    }

    public function getMoney(): int
    {
        return $this->money;
    }
}

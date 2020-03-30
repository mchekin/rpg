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
 * @property string type
 * @property string character_id
 */
class Store extends Model
{
    use UsesStringId;

    protected $guarded = [];

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'character_id');
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'store_item')
            ->withPivot('inventory_slot_number', 'price');
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCharacterId(): string
    {
        return $this->character_id;
    }
}

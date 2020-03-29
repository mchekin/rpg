<?php

namespace App;

use App\Modules\Equipment\Domain\ItemStatus;
use App\Traits\UsesStringId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string id
 * @property string name
 * @property string $description
 * @property string image_file_path
 * @property string type
 * @property string status
 * @property array effects
 * @property string prototype_id
 * @property string creator_character_id
 * @property string owner_character_id
 * @property int inventory_slot_number
 * @property int price
 * @property Inventory inventory
 * @property mixed pivot
 */
class Item extends Model
{
    use UsesStringId;

    protected $guarded = [];

    protected $casts = [
        'effects' => 'array'
    ];

    public function inventory(): BelongsToMany
    {
        return $this->belongsToMany(Inventory::class);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImageFilePath(): string
    {
        return $this->image_file_path;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getEffects(): array
    {
        return $this->effects;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getPrototypeId(): string
    {
        return $this->prototype_id;
    }

    public function getCreatorCharacterId(): string
    {
        return $this->creator_character_id;
    }

    public function getOwnerCharacterId(): string
    {
        return $this->owner_character_id;
    }

    public function getInventorySlotNumber(): int
    {
        return $this->inventory_slot_number;
    }

    public function isEquipped(): bool
    {
        return $this->pivot->status === ItemStatus::EQUIPPED;
    }
}

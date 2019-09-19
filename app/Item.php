<?php

namespace App;

use App\Traits\UsesStringId;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string id
 * @property string name
 * @property string $description
 * @property string image_file_path
 * @property string type
 * @property array effects
 * @property string prototype_id
 * @property string creator_character_id
 * @property string owner_character_id
 * @property int inventory_slot_number
 */
class Item extends Model
{
    use UsesStringId;

    protected $guarded = [];

    protected $casts = [
        'effects' => 'array'
    ];

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

    public function getEffects(): array
    {
        return $this->effects;
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

    public function getInventorySlotNumber()
    {
        return $this->inventory_slot_number;
    }
}

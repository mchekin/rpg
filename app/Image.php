<?php

namespace App;

use App\Traits\UsesStringId;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string file_path_full
 * @property string file_path_small
 * @property string file_path_icon
 * @property string id
 * @property string character_id
 */
class Image extends Model
{
    use UsesStringId;

    protected $guarded = [];

    public function getId()
    {
        return $this->id;
    }

    public function getCharacterId(): string
    {
        return $this->character_id;
    }

    public function getFilePathFull(): string
    {
        return $this->file_path_full;
    }

    public function getFilePathSmall(): string
    {
        return $this->file_path_small;
    }

    public function getFilePathIcon(): string
    {
        return $this->file_path_icon;
    }
}

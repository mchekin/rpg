<?php

namespace App;

use App\Contracts\Models\ImageInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string file_path_full
 * @property string file_path_small
 * @property string file_path_icon
 * @property int id
 */
class Image extends Model implements ImageInterface
{
    protected $fillable = [
        'file_path_full',
        'file_path_small',
        'file_path_icon',
    ];

    public function getId(): int
    {
        return $this->id;
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

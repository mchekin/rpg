<?php

namespace App;

use App\Contracts\Models\ImageInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string filename
 * @property int id
 */
class Image extends Model implements ImageInterface
{
    protected $fillable = [
        'filename',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}

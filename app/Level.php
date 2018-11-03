<?php

namespace App;

use App\Contracts\Models\LevelInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property integer next_level_xp_threshold
 */
class Level extends Model implements LevelInterface
{
    /**
     * @return LevelInterface|null
     */
    public function nextLevel()
    {
        return Level::query()->find($this->id + 1);
    }
}

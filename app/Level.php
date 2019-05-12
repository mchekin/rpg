<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property integer next_level_xp_threshold
 */
class Level extends Model
{
    public function getNextLevelXpThreshold()
    {
        return $this->next_level_xp_threshold;
    }

    public function getId(): int
    {
        return $this->id;
    }
}

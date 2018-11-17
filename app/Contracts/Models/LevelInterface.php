<?php

namespace App\Contracts\Models;


/**
 * @property integer id
 * @property integer next_level_xp_threshold
 */
interface LevelInterface
{
    /**
     * @return LevelInterface|null
     */
    public function nextLevel();

    public function getNextLevelXpThreshold();

    public function getId(): int;
}
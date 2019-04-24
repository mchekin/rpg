<?php

namespace App\Modules\Level\Domain\Contracts;

use App\Modules\Level\Domain\Entities\Level;

interface LevelRepositoryInterface
{
    public function getOne(int $levelId): Level;

    public function getLevelByXp(int $xp): Level;
}
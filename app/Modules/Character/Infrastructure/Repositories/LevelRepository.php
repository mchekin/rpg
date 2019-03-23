<?php

namespace App\Modules\Character\Infrastructure\Repositories;

use App\Modules\Character\Domain\Contracts\LevelRepositoryInterface;
use App\Modules\Character\Domain\Models\Level;

class LevelRepository implements LevelRepositoryInterface
{
    public function get(int $levelId): Level
    {
        return new Level($levelId);
    }
}
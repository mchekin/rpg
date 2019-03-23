<?php

namespace App\Modules\Character\Domain\Contracts;

use App\Modules\Character\Domain\Models\Level;

interface LevelRepositoryInterface
{
    public function get(int $levelId): Level;
}
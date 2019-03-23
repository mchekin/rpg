<?php

namespace App\Modules\Character\Domain\Contracts;

use App\Modules\Character\Domain\Entities\Level;

interface LevelRepositoryInterface
{
    public function get(int $levelId): Level;
}
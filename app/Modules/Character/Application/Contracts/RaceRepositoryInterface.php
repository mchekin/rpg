<?php

namespace App\Modules\Character\Application\Contracts;

use App\Modules\Character\Domain\Race;

interface RaceRepositoryInterface
{
    public function getOne(int $raceId): Race;
}

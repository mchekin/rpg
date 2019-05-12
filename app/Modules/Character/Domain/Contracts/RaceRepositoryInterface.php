<?php

namespace App\Modules\Character\Domain\Contracts;

use App\Modules\Character\Domain\Entities\Race;

interface RaceRepositoryInterface
{
    public function getOne(int $raceId): Race;
}
<?php

namespace App\Modules\Character\Domain\Contracts;

use App\Modules\Character\Domain\Models\Race;

interface RaceRepositoryInterface
{
    public function get(int $raceId): Race;
}
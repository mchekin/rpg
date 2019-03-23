<?php

namespace App\Modules\Character\Domain\Contracts;

use App\Modules\Character\Domain\Models\Location;

interface LocationRepositoryInterface
{
    public function get(int $locationId): Location;
}
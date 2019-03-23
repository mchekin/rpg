<?php

namespace App\Modules\Character\Domain\Contracts;

use App\Modules\Character\Domain\Entities\Location;

interface LocationRepositoryInterface
{
    public function get(int $locationId): Location;
}
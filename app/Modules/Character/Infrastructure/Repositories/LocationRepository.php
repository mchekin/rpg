<?php

namespace App\Modules\Character\Infrastructure\Repositories;

use App\Modules\Character\Domain\Contracts\LocationRepositoryInterface;
use App\Modules\Character\Domain\Entities\Location;

class LocationRepository implements LocationRepositoryInterface
{
    public function get(int $levelId): Location
    {
        return new Location($levelId);
    }
}
<?php

namespace App\Modules\Character\Infrastructure\Repositories;

use App\Modules\Character\Application\Contracts\LocationRepositoryInterface;
use App\Modules\Character\Domain\LocationId;
use App\Traits\GeneratesUuid;
use Exception;

class LocationRepository implements LocationRepositoryInterface
{
    use GeneratesUuid;

    /**
     * @return LocationId
     *
     * @throws Exception
     */
    public function nextIdentity(): LocationId
    {
        return LocationId::fromString($this->generateUuid());
    }
}

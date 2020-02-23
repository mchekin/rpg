<?php

namespace App\Modules\Character\Application\Contracts;

use App\Modules\Character\Domain\LocationId;

interface LocationRepositoryInterface
{
    public function nextIdentity(): LocationId;
}

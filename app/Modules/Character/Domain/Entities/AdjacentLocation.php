<?php

namespace App\Modules\Character\Domain\Entities;

use Carbon\Carbon;

class AdjacentLocation
{
    /**
     * @var string
     */
    private $locationId;
    /**
     * @var string
     */
    private $adjacentLocationId;
    /**
     * @var string
     */
    private $direction;
    /**
     * @var Carbon
     */
    private $createdAt;
    /**
     * @var Carbon
     */
    private $updatedAt;

    public function __construct(
        string $locationId,
        string $adjacentLocationId,
        string $direction
    )
    {

        $this->locationId = $locationId;
        $this->adjacentLocationId = $adjacentLocationId;
        $this->direction = $direction;
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();
    }
}

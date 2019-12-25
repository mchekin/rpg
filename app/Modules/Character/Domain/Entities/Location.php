<?php

namespace App\Modules\Character\Domain\Entities;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;

class Location
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $image;
    /**
     * @var string
     */
    private $imageSm;
    /**
     * @var ArrayCollection
     */
    private $adjacentLocations;
    /**
     * @var ArrayCollection
     */
    private $characters;
    /**
     * @var Carbon
     */
    private $createdAt;
    /**
     * @var Carbon
     */
    private $updatedAt;

    public function __construct(
        string $id,
        string $name,
        string $description,
        string $image,
        string $imageSm
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->imageSm = $imageSm;
        $this->adjacentLocations = new ArrayCollection();
        $this->characters = new ArrayCollection();
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();
    }
}

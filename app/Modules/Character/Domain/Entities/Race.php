<?php


namespace App\Modules\Character\Domain\Entities;


use App\Modules\Character\Domain\ValueObjects\Attributes;
use App\Modules\Character\Domain\ValueObjects\Gender;
use Carbon\Carbon;

class Race
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var Location
     */
    private $startingLocation;
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
    private $maleImage;
    /**
     * @var string
     */
    private $femaleImage;
    /**
     * @var Attributes
     */
    private $attributes;
    /**
     * @var Carbon
     */
    private $createdAt;
    /**
     * @var Carbon
     */
    private $updatedAt;

    public function __construct(
        int $id,
        Location $startingLocation,
        string $name,
        string $description,
        string $maleImage,
        string $femaleImage,
        Attributes $attributes
    ) {
        $this->id = $id;
        $this->startingLocation = $startingLocation;
        $this->name = $name;
        $this->description = $description;
        $this->maleImage = $maleImage;
        $this->femaleImage = $femaleImage;
        $this->attributes = $attributes;
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getImageByGender(Gender $gender):string
    {
        return $this->{"{$gender->getValue()}Image"};
    }

    public function getStartingLocation(): Location
    {
        return $this->startingLocation;
    }

    public function getStrength(): int
    {
        return $this->attributes->getStrength();
    }

    public function getAgility(): int
    {
        return $this->attributes->getAgility();
    }

    public function getConstitution(): int
    {
        return $this->attributes->getConstitution();
    }

    public function getIntelligence(): int
    {
        return $this->attributes->getIntelligence();
    }

    public function getCharisma(): int
    {
        return $this->attributes->getCharisma();
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getMaleImage(): string
    {
        return $this->maleImage;
    }

    public function getFemaleImage(): string
    {
        return $this->femaleImage;
    }
}

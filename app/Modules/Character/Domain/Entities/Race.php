<?php


namespace App\Modules\Character\Domain\Entities;


class Race
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $startingLocationId;
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

    public function __construct(
        int $id,
        string $startingLocationId,
        string $name,
        string $description,
        string $maleImage,
        string $femaleImage,
        Attributes $attributes
    ) {
        $this->id = $id;
        $this->startingLocationId = $startingLocationId;
        $this->name = $name;
        $this->description = $description;
        $this->maleImage = $maleImage;
        $this->femaleImage = $femaleImage;
        $this->attributes = $attributes;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getImageByGender(string $gender):string
    {
        return $this->{"{$gender}_image"};
    }
    
    public function getStartingLocationId(): string
    {
        return $this->startingLocationId;
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

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getMaleImage(): string
    {
        return $this->maleImage;
    }

    /**
     * @return string
     */
    public function getFemaleImage(): string
    {
        return $this->femaleImage;
    }
}
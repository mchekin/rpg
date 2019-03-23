<?php


namespace App\Modules\Character\Domain\Entities;


class Race
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var int
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
        int $startingLocationId,
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

    public function getStartingLocationId(): int
    {
        return $this->startingLocationId;
    }

    public function getStrength(): int
    {
        return $this->attributes->get('strength');
    }

    public function getAgility(): int
    {
        return $this->attributes->get('agility');
    }

    public function getConstitution(): int
    {
        return $this->attributes->get('constitution');
    }

    public function getIntelligence(): int
    {
        return $this->attributes->get('intelligence');
    }

    public function getCharisma(): int
    {
        return $this->attributes->get('charisma');
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
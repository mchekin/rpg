<?php


namespace App\Modules\Character\Domain\ValueObjects;

use DomainException;
use InvalidArgumentException;

class Attributes
{
    /**
     * @var int
     */
    private $strength;
    /**
     * @var int
     */
    private $constitution;
    /**
     * @var int
     */
    private $agility;
    /**
     * @var int
     */
    private $intelligence;
    /**
     * @var int
     */
    private $charisma;
    /**
     * @var int
     */
    private $unassigned;

    public function __construct(
        int $strength,
        int $constitution,
        int $agility,
        int $intelligence,
        int $charisma,
        int $unassigned
    )
    {
        $this->strength = $strength;
        $this->constitution = $constitution;
        $this->agility = $agility;
        $this->intelligence = $intelligence;
        $this->charisma = $charisma;
        $this->unassigned = $unassigned;
    }

    public function addAvailablePoints(int $points): Attributes
    {
        return new static(
            $this->strength,
            $this->constitution,
            $this->agility,
            $this->intelligence,
            $this->charisma,
            $this->unassigned + $points
        );
    }

    public function assignAvailablePoint(string $attribute): Attributes
    {
        if (!$this->hasAvailablePoints())
        {
            throw new DomainException('No available points to assign.');
        }

        switch ($attribute)
        {
            case 'strength':
                return new static(
                    $this->strength + 1,
                    $this->constitution,
                    $this->agility,
                    $this->intelligence,
                    $this->charisma,
                    $this->unassigned - 1
                );
            case 'constitution':
                return new static(
                    $this->strength,
                    $this->constitution + 1,
                    $this->agility,
                    $this->intelligence,
                    $this->charisma,
                    $this->unassigned - 1
                );
            case 'agility':
                return new static(
                    $this->strength,
                    $this->constitution,
                    $this->agility + 1,
                    $this->intelligence,
                    $this->charisma,
                    $this->unassigned - 1
                );
            case 'intelligence':
                return new static(
                    $this->strength + 1,
                    $this->constitution,
                    $this->agility,
                    $this->intelligence,
                    $this->charisma,
                    $this->unassigned - 1
                );
            case 'charisma':
                return new static(
                    $this->strength + 1,
                    $this->constitution,
                    $this->agility,
                    $this->intelligence,
                    $this->charisma,
                    $this->unassigned - 1
                );
            default:
                throw new InvalidArgumentException('Unknown attribute.');
        }
    }

    public function hasAvailablePoints(): bool
    {
        return $this->unassigned > 0;
    }

    public function getStrength(): int
    {
        return $this->strength;
    }

    public function getAgility(): int
    {
        return $this->agility;
    }

    public function getConstitution(): int
    {
        return $this->constitution;
    }

    public function getIntelligence(): int
    {
        return $this->intelligence;
    }

    public function getCharisma(): int
    {
        return $this->charisma;
    }

    public function getUnassigned(): int
    {
        return $this->unassigned;
    }
}

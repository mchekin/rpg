<?php


namespace App\Modules\Character\Domain\Entities;


use Illuminate\Support\Collection;

class Attributes
{
    /**
     * @var Collection
     */
    private $collection;

    public function __construct($items = [])
    {
        $this->collection = new Collection($items);
    }

    public function addAvailablePoints(int $points): Attributes
    {
        $rawData = $this->collection->all();

        $rawData['unassigned'] += $points;

        return new static($rawData);
    }

    public function assignAvailablePoint(string $attribute): Attributes
    {
        $rawData = $this->collection->all();

        $rawData['unassigned']--;
        $rawData[$attribute]++;

        return new static($rawData);
    }

    public function hasAvailablePoints(): bool
    {
        return (bool)$this->collection->get('unassigned');
    }

    public function getStrength(): int
    {
        return $this->collection->get('strength');
    }

    public function getAgility(): int
    {
        return $this->collection->get('agility');
    }

    public function getConstitution(): int
    {
        return $this->collection->get('constitution');
    }

    public function getIntelligence(): int
    {
        return $this->collection->get('intelligence');
    }

    public function getCharisma(): int
    {
        return $this->collection->get('charisma');
    }

    public function getUnassignedAttributePoints(): int
    {
        return $this->collection->get('unassigned');
    }
}
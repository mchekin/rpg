<?php

namespace App;

use App\Contracts\Models\RaceInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 */
class Race extends Model implements RaceInterface
{
    const ATTRIBUTE_STRENGTH = 'strength';
    const ATTRIBUTE_AGILITY = 'agility';
    const ATTRIBUTE_CONSTITUTION = 'constitution';
    const ATTRIBUTE_INTELLIGENCE = 'intelligence';
    const ATTRIBUTE_CHARISMA = 'charisma';

    const ATTRIBUTE_STARTING_LOCATION_ID = 'starting_location_id';
    const ATTRIBUTE_NAME = 'name';

    public function getImageByGender(string $gender):string
    {
        return $this->{"{$gender}_image"};
    }

    public function getId(): int
    {
        return $this->getKey();
    }

    public function getStartingLocationId(): int
    {
        return $this->{self::ATTRIBUTE_STARTING_LOCATION_ID};
    }

    public function getStrength(): int
    {
        return $this->{self::ATTRIBUTE_STRENGTH};
    }

    public function getAgility(): int
    {
        return $this->{self::ATTRIBUTE_AGILITY};
    }

    public function getConstitution(): int
    {
        return $this->{self::ATTRIBUTE_CONSTITUTION};
    }

    public function getIntelligence(): int
    {
        return $this->{self::ATTRIBUTE_INTELLIGENCE};
    }

    public function getCharisma(): int
    {
        return $this->{self::ATTRIBUTE_CHARISMA};
    }

    public function getName(): string
    {
        return $this->name;
    }
}

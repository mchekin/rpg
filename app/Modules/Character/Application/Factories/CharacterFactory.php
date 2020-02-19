<?php


namespace App\Modules\Character\Application\Factories;

use App\Modules\Character\Application\Commands\CreateCharacterCommand;
use App\Modules\Character\Domain\Entities\Race;
use App\Modules\Character\Domain\ValueObjects\Inventory;
use App\Modules\Character\Domain\ValueObjects\Statistics;
use App\Traits\GeneratesUuid;
use App\Modules\Character\Domain\ValueObjects\Attributes;
use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Character\Domain\ValueObjects\Gender;
use App\Modules\Character\Domain\ValueObjects\HitPoints;
use App\Modules\Character\Domain\ValueObjects\Money;
use App\Modules\Character\Domain\ValueObjects\Reputation;


class CharacterFactory
{
    use GeneratesUuid;

    public function create(CreateCharacterCommand $command, Race $race): Character
    {
        return new Character(
            $this->generateUuid(),
            $race->getId(),
            1,
            $race->getStartingLocationId(),
            $command->getName(),
            new Gender($command->getGender()),
            0,
            new Money(0),
            new Reputation(0),
            new Attributes([
                'strength' => $race->getStrength(),
                'agility' => $race->getAgility(),
                'constitution' => $race->getConstitution(),
                'intelligence' => $race->getIntelligence(),
                'charisma' => $race->getCharisma(),
                'unassigned' => 0,
            ]),
            HitPoints::byRace($race),
            new Statistics([
                'battlesLost' => 0,
                'battlesWon' => 0,
            ]),
            Inventory::empty(),
            $command->getUserId()
        );
    }
}

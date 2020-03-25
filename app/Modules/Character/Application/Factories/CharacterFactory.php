<?php


namespace App\Modules\Character\Application\Factories;

use App\Modules\Character\Application\Commands\CreateCharacterCommand;
use App\Modules\Character\Domain\CharacterId;
use App\Modules\Character\Domain\Race;
use App\Modules\Equipment\Domain\Inventory;
use App\Modules\Character\Domain\Statistics;
use App\Modules\Character\Domain\Attributes;
use App\Modules\Character\Domain\Character;
use App\Modules\Character\Domain\Gender;
use App\Modules\Character\Domain\HitPoints;
use App\Modules\Character\Domain\Money;
use App\Modules\Character\Domain\Reputation;


class CharacterFactory
{
    public function create(CharacterId $characterId, CreateCharacterCommand $command, Race $race, Inventory $inventory): Character
    {
        return new Character(
            $characterId,
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
            $inventory,
            $command->getUserId()
        );
    }
}

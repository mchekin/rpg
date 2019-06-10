<?php


namespace App\Modules\Character\Domain\Factories;

use App\Modules\Character\Domain\ValueObjects\Statistics;
use App\Traits\GeneratesUuid;
use App\Modules\Character\Domain\Contracts\RaceRepositoryInterface;
use App\Modules\Character\Domain\Entities\Attributes;
use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Character\Domain\Entities\Gender;
use App\Modules\Character\Domain\ValueObjects\HitPoints;
use App\Modules\Character\Domain\ValueObjects\Money;
use App\Modules\Character\Domain\ValueObjects\Reputation;
use App\Modules\Character\Domain\Commands\CreateCharacterCommand;


class CharacterFactory
{
    use GeneratesUuid;

    /**
     * @var RaceRepositoryInterface
     */
    private $raceRepository;

    public function __construct(RaceRepositoryInterface $raceRepository)
    {
        $this->raceRepository = $raceRepository;
    }

    public function create(CreateCharacterCommand $command): Character
    {
        $race = $this->raceRepository->getOne($command->getRaceId());

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
            $command->getUserId()
        );
    }
}
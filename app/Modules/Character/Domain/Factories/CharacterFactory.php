<?php


namespace App\Modules\Character\Domain\Factories;

use App\Modules\Auth\Domain\Contracts\UserRepositoryInterface;
use App\Modules\Character\Domain\ValueObjects\Inventory;
use App\Modules\Character\Domain\ValueObjects\Statistics;
use App\Traits\GeneratesUuid;
use App\Modules\Character\Domain\Contracts\RaceRepositoryInterface;
use App\Modules\Character\Domain\ValueObjects\Attributes;
use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Character\Domain\ValueObjects\Gender;
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
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(RaceRepositoryInterface $raceRepository, UserRepositoryInterface $userRepository)
    {
        $this->raceRepository = $raceRepository;
        $this->userRepository = $userRepository;
    }

    public function create(CreateCharacterCommand $command): Character
    {
        $race = $this->raceRepository->getOne($command->getRaceId());
        $user = $this->userRepository->getOne($command->getUserId());

        return new Character(
            $this->generateUuid(),
            $race,
            1,
            $race->getStartingLocation(),
            $command->getName(),
            new Gender($command->getGender()),
            0,
            new Money(0),
            new Reputation(0),
            new Attributes(
                $race->getStrength(),
                $race->getAgility(),
                $race->getConstitution(),
                $race->getIntelligence(),
                $race->getCharisma(),
                0
            ),
            HitPoints::byRace($race),
            new Statistics(
                0,
                0
            ),
            $user
        );
    }
}

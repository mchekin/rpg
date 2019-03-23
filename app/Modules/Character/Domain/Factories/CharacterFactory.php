<?php


namespace App\Modules\Character\Domain\Factories;

use App\Factories\GeneratesUuid;
use App\Modules\Character\Domain\Contracts\RaceRepositoryInterface;
use App\Modules\Character\Domain\Models\Attributes;
use App\Modules\Character\Domain\Models\Character;
use App\Modules\Character\Domain\Models\Gender;
use App\Modules\Character\Domain\Models\Money;
use App\Modules\Character\Domain\Models\ValueObjects\HitPoints;
use App\Modules\Character\Domain\Models\ValueObjects\Reputation;
use App\Modules\Character\Domain\Models\ValueObjects\Xp;
use App\Modules\Character\Domain\Requests\CreateCharacterRequest;


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

    public function create(CreateCharacterRequest $request): Character
    {
        $race = $this->raceRepository->get($request->getRaceId());

        return new Character(
            $this->generateUuid(),
            $request->getUserId(),
            $race->getId(),
            1,
            $race->getStartingLocationId(),
            $request->getName(),
            new Gender($request->getGender()),
            new Xp(0),
            new Money(0),
            new Reputation(0),
            new Attributes([
                'strength' => $race->getStrength(),
                'agility' => $race->getAgility(),
                'constitution' => $race->getConstitution(),
                'intelligence' => $race->getIntelligence(),
                'charisma' => $race->getCharisma(),
            ]),
            new HitPoints(
                $this->calculateHP($race->getConstitution()),
                $this->calculateHP($race->getConstitution())
            )
        );
    }

    protected function calculateHP(int $constitution): int
    {
        return $constitution * 10 + $this->throwTwoDices();
    }

    protected function throwTwoDices(): int
    {
        return $this->throwOneDice() + $this->throwOneDice();
    }

    protected function throwOneDice(): int
    {
        return rand(1, 6);
    }
}
<?php

namespace App\Modules\Character\Infrastructure\Repositories;

use App\Modules\Character\Domain\Contracts\RaceRepositoryInterface;
use App\Modules\Character\Domain\ValueObjects\Attributes;
use App\Modules\Character\Domain\Entities\Race;
use App\Race as RaceModel;

class RaceRepository implements RaceRepositoryInterface
{
    public function getOne(int $raceId): Race
    {
        /** @var RaceModel $race */
        $race = RaceModel::query()->findOrFail($raceId);

        return new Race(
            $race->getId(),
            $race->getStartingLocationId(),
            $race->getName(),
            $race->getDescription(),
            $race->getMaleImage(),
            $race->getFemaleImage(),
            new Attributes([
                'strength' => $race->getStrength(),
                'agility' => $race->getAgility(),
                'constitution' => $race->getConstitution(),
                'intelligence' => $race->getIntelligence(),
                'charisma' => $race->getCharisma(),
            ])
        );
    }
}
<?php


namespace App\Modules\Character\Infrastructure\ReconstitutionFactories;

use App\Modules\Character\Domain\Entities\Attributes;
use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Character\Domain\Entities\Gender;
use App\Modules\Character\Domain\ValueObjects\Statistics;
use App\Modules\Character\Domain\ValueObjects\Money;
use App\Modules\Character\Domain\ValueObjects\HitPoints;
use App\Modules\Character\Domain\ValueObjects\Reputation;
use App\Character as CharacterModel;


class CharacterReconstitutionFactory
{
    public function reconstitute(CharacterModel $characterModel): Character
    {
        $character = new Character(
            $characterModel->getId(),
            $characterModel->getUserId(),
            $characterModel->getRaceId(),
            $characterModel->getLevelNumber(),
            $characterModel->getLocationId(),
            $characterModel->getName(),
            new Gender($characterModel->getGender()),
            $characterModel->getXp(),
            new Money(0),
            new Reputation(0),
            new Attributes([
                'strength' => $characterModel->getStrength(),
                'agility' => $characterModel->getAgility(),
                'constitution' => $characterModel->getConstitution(),
                'intelligence' => $characterModel->getIntelligence(),
                'charisma' => $characterModel->getCharisma(),
                'unassigned' => $characterModel->getAvailableAttributePoints(),
            ]),
            new HitPoints(
                $characterModel->getHitPoints(),
                $characterModel->getTotalHitPoints()
            ),
            new Statistics([
                'battlesLost' => $characterModel->getBattlesLost(),
                'battlesWon' => $characterModel->getBattlesWon(),
            ])
        );

        $character->setModel($characterModel);

        return $character;
    }
}
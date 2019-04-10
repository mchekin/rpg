<?php


namespace App\Modules\Character\Infrastructure\ReconstitutionFactories;

use App\Modules\Character\Domain\Entities\Attributes;
use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Character\Domain\Entities\Gender;
use App\Modules\Character\Domain\Entities\Money;
use App\Modules\Character\Domain\Entities\ValueObjects\HitPoints;
use App\Modules\Character\Domain\Entities\ValueObjects\Reputation;
use App\Modules\Character\Domain\Entities\ValueObjects\Xp;
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
            new Xp($characterModel->getXp()),
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
            )
        );

        $character->setCharacterModel($characterModel);

        return $character;
    }
}
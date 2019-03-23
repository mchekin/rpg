<?php


namespace App\Modules\Character\Infrastructure\ReconstitutionFactories;

use App\Modules\Character\Domain\Models\Attributes;
use App\Modules\Character\Domain\Models\Character;
use App\Modules\Character\Domain\Models\Gender;
use App\Modules\Character\Domain\Models\Money;
use App\Modules\Character\Domain\Models\ValueObjects\HitPoints;
use App\Modules\Character\Domain\Models\ValueObjects\Reputation;
use App\Modules\Character\Domain\Models\ValueObjects\Xp;
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
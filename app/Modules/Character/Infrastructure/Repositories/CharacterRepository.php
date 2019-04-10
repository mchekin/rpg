<?php

namespace App\Modules\Character\Infrastructure\Repositories;

use App\Modules\Character\Domain\Contracts\CharacterRepositoryInterface;
use App\Modules\Character\Domain\Entities\Character;
use App\Character as CharacterModel;
use App\Modules\Character\Infrastructure\ReconstitutionFactories\CharacterReconstitutionFactory;

class CharacterRepository implements CharacterRepositoryInterface
{
    /**
     * @var CharacterReconstitutionFactory
     */
    private $characterReconstitutionFactory;

    public function __construct(CharacterReconstitutionFactory $characterReconstitutionFactory)
    {
        $this->characterReconstitutionFactory = $characterReconstitutionFactory;
    }

    public function add(Character $character)
    {
        /** @var CharacterModel $characterModel */
        $characterModel = CharacterModel::query()->create([
            'id' => $character->getId(),
            'user_id' => $character->getUserId(),

            'name' => $character->getName(),
            'gender' => $character->getGender()->getValue(),

            'xp' => $character->getXp()->getValue(),
            'level_id' => $character->getLevelNumber(),
            'money' => $character->getMoney()->getValue(),
            'reputation' => $character->getReputation()->getValue(),

            'strength' => $character->getStrength(),
            'agility' => $character->getAgility(),
            'constitution' => $character->getConstitution(),
            'intelligence' => $character->getIntelligence(),
            'charisma' => $character->getCharisma(),

            'hit_points' => $character->getHitPoints(),
            'total_hit_points' => $character->getTotalHitPoints(),

            'race_id' => $character->getRaceId(),
            'location_id' => $character->getLocationId(),
        ]);

        $character->setCharacterModel($characterModel);
    }

    public function getOne(string $characterId): Character
    {
        /** @var CharacterModel $characterModel */
        $characterModel = CharacterModel::query()->findOrFail($characterId);

        return $this->characterReconstitutionFactory->reconstitute($characterModel);
    }

    public function update(Character $character)
    {
        CharacterModel::query()->where('id', $character->getId())->update(
            [
                'name' => $character->getName(),
                'gender' => $character->getGender()->getValue(),

                'xp' => $character->getXp()->getValue(),
                'level_id' => $character->getLevelNumber(),
                'money' => $character->getMoney()->getValue(),
                'reputation' => $character->getReputation()->getValue(),

                'strength' => $character->getStrength(),
                'agility' => $character->getAgility(),
                'constitution' => $character->getConstitution(),
                'intelligence' => $character->getIntelligence(),
                'charisma' => $character->getCharisma(),

                'hit_points' => $character->getHitPoints(),
                'total_hit_points' => $character->getTotalHitPoints(),

                'location_id' => $character->getLocationId(),
            ]
        );
    }
}
<?php


namespace App\Modules\Character\Infrastructure\ReconstitutionFactories;

use App\Modules\Equipment\Infrastructure\ReconstitutionFactories\ItemReconstitutionFactory;
use App\Modules\Character\Domain\Entities\Attributes;
use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Character\Domain\Entities\Gender;
use App\Modules\Character\Domain\ValueObjects\Inventory;
use App\Modules\Character\Domain\ValueObjects\Statistics;
use App\Modules\Character\Domain\ValueObjects\Money;
use App\Modules\Character\Domain\ValueObjects\HitPoints;
use App\Modules\Character\Domain\ValueObjects\Reputation;
use App\Character as CharacterModel;
use App\Item as ItemModel;


class CharacterReconstitutionFactory
{
    /**
     * @var ItemReconstitutionFactory
     */
    private $itemReconstitutionFactory;

    public function __construct(ItemReconstitutionFactory $itemReconstitutionFactory)
    {
        $this->itemReconstitutionFactory = $itemReconstitutionFactory;
    }

    public function reconstitute(CharacterModel $characterModel): Character
    {
        $items = $characterModel->items->map(function (ItemModel $itemModel) {
                 return $this->itemReconstitutionFactory->reconstitute($itemModel);
             })->all();

        $character = new Character(
            $characterModel->getId(),
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
            ]),
            Inventory::withItems($items),
            $characterModel->getUserId(),
            $characterModel->getProfilePictureId()
        );

        $character->setModel($characterModel);

        return $character;
    }
}
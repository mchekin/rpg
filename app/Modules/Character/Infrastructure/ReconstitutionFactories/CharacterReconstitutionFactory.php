<?php


namespace App\Modules\Character\Infrastructure\ReconstitutionFactories;

use App\Modules\Equipment\Infrastructure\ReconstitutionFactories\ItemReconstitutionFactory;
use App\Modules\Character\Domain\ValueObjects\Attributes;
use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Character\Domain\ValueObjects\Gender;
use App\Modules\Character\Domain\ValueObjects\Inventory;
use App\Modules\Character\Domain\ValueObjects\Statistics;
use App\Modules\Character\Domain\ValueObjects\Money;
use App\Modules\Character\Domain\ValueObjects\HitPoints;
use App\Modules\Character\Domain\ValueObjects\Reputation;
use App\Character as CharacterModel;
use App\Item as ItemModel;
use Doctrine\Common\Collections\ArrayCollection;


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
        });

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
            new Attributes(
                $characterModel->getStrength(),
                $characterModel->getAgility(),
                $characterModel->getConstitution(),
                $characterModel->getIntelligence(),
                $characterModel->getCharisma(),
                $characterModel->getAvailableAttributePoints()
            ),
            new HitPoints(
                $characterModel->getHitPoints(),
                $characterModel->getTotalHitPoints()
            ),
            new Statistics(
                $characterModel->getBattlesLost(),
                $characterModel->getBattlesWon()
            ),
            Inventory::withItems(new ArrayCollection($items->all())),
            $characterModel->getUserId(),
            $characterModel->getProfilePictureId()
        );

        $character->setModel($characterModel);

        return $character;
    }
}

<?php


namespace App\Modules\Character\Domain\Entities;

use App\Modules\Character\Domain\ValueObjects\Attributes;
use App\Modules\Character\Domain\ValueObjects\Gender;
use App\Modules\Character\Domain\ValueObjects\HitPoints;
use App\Modules\Character\Domain\ValueObjects\Inventory;
use App\Modules\Character\Domain\ValueObjects\Reputation;
use App\Modules\Character\Domain\ValueObjects\Money;
use App\Modules\Character\Domain\ValueObjects\Statistics;
use App\Modules\Equipment\Domain\Entities\Item;
use App\Traits\ContainsModel;

class Character
{
    // Todo: temporary hack of having reference to the Eloquent model
    use ContainsModel;

    /**
     * @var string
     */
    private $name;
    /**
     * @var Gender
     */
    private $gender;
    /**
     * @var int
     */
    private $levelId;
    /**
     * @var int
     */
    private $raceId;
    /**
     * @var string
     */
    private $locationId;
    /**
     * @var int
     */
    private $xp;
    /**
     * @var Money
     */
    private $money;
    /**
     * @var Reputation
     */
    private $reputation;
    /**
     * @var Attributes
     */
    private $attributes;
    /**
     * @var HitPoints
     */
    private $hitPoints;
    /**
     * @var string
     */
    private $id;
    /**
     * @var Statistics
     */
    private $statistics;
    /**
     * @var Inventory
     */
    private $inventory;
    /**
     * @var int|null
     */
    private $userId;
    /**
     * @var string
     */
    private $profilePictureId;

    public function __construct(
        string $id,
        int $raceId,
        int $levelId,
        string $locationId,
        string $name,
        Gender $gender,
        int $xp,
        Money $money,
        Reputation $reputation,
        Attributes $attributes,
        HitPoints $hitPoints,
        Statistics $statistics,
        Inventory $inventory,
        int $userId = null,
        string $profilePictureId = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->gender = $gender;
        $this->levelId = $levelId;
        $this->raceId = $raceId;
        $this->locationId = $locationId;
        $this->xp = $xp;
        $this->money = $money;
        $this->reputation = $reputation;
        $this->attributes = $attributes;
        $this->hitPoints = $hitPoints;
        $this->statistics = $statistics;
        $this->inventory = $inventory;
        $this->userId = $userId;
        $this->profilePictureId = $profilePictureId;
    }

    public function getLevelNumber(): int
    {
        return $this->levelId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStrength(): int
    {
        return $this->attributes->getStrength();
    }

    public function getAgility(): int
    {
        return $this->attributes->getAgility();
    }

    public function getConstitution(): int
    {
        return $this->attributes->getConstitution();
    }

    public function getIntelligence(): int
    {
        return $this->attributes->getIntelligence();
    }

    public function getCharisma(): int
    {
        return $this->attributes->getCharisma();
    }

    public function getUnassignedAttributePoints(): int
    {
        return $this->attributes->getUnassignedAttributePoints();
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }

    public function getHitPoints(): int
    {
        return $this->hitPoints->getCurrentHitPoints();
    }

    public function getTotalHitPoints(): int
    {
        return $this->hitPoints->getMaximumHitPoints();
    }

    public function equals(Character $other): bool
    {
        return $this->getName() === $other->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function getXp(): int
    {
        return $this->xp;
    }

    public function getRaceId(): int
    {
        return $this->raceId;
    }

    public function getMoney(): Money
    {
        return $this->money;
    }

    public function getReputation(): Reputation
    {
        return $this->reputation;
    }

    public function applyAttributeIncrease(string $attribute)
    {
        if ($this->attributes->hasAvailablePoints()) {

            $this->attributes = $this->attributes->assignAvailablePoint($attribute);

            if ($attribute === 'constitution') {
                $this->hitPoints = $this->hitPoints->withIncrementedConstitution();
            }
        }
    }

    public function addItemToInventorySlot(int $slot, Item $item)
    {
        $this->inventory = $this->inventory->withAddedItem($slot, $item);
    }

    public function addItemToInventory(Item $item)
    {
        $this->inventory = $this->inventory->withAddedItemToFreeSlot($item);
    }

    public function setLocationId(string $locationId)
    {
        $this->locationId = $locationId;
    }

    public function isAlive(): bool
    {
        return $this->hitPoints->getCurrentHitPoints() > 0;
    }

    public function incrementWonBattles()
    {
        $this->statistics = $this->statistics->withIncreaseWonBattles();
    }

    public function incrementLostBattles()
    {
        $this->statistics = $this->statistics->withIncreaseLostBattles();
    }

    public function addXp(int $xp)
    {
        $this->xp = $this->xp + $xp;
    }

    public function getBattlesWon(): int
    {
        return (int) $this->statistics->get('battlesWon');
    }

    public function getBattlesLost(): int
    {
        return (int) $this->statistics->get('battlesLost');
    }

    public function applyDamage($damageDone)
    {
        $this->hitPoints = $this->hitPoints->withUpdatedCurrentValue(-$damageDone);
    }

    public function updateLevel(int $levelId)
    {
        $points = $levelId - $this->levelId;

        $this->levelId = $levelId;

        $this->attributes = $this->attributes->addAvailablePoints($points);
    }

    public function setProfilePictureId(string $profilePictureId)
    {
        $this->profilePictureId = $profilePictureId;
    }

    /**
     * @return string|null
     */
    public function getProfilePictureId()
    {
        return $this->profilePictureId;
    }

    public function removeProfilePicture()
    {
        $this->profilePictureId = null;
    }

    public function getInventory(): Inventory
    {
        return $this->inventory;
    }
}
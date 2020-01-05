<?php

namespace App\Modules\Character\Domain\Entities;

use App\Modules\Auth\Domain\Entities\User;
use App\Modules\Character\Domain\ValueObjects\Attributes;
use App\Modules\Character\Domain\ValueObjects\Gender;
use App\Modules\Character\Domain\ValueObjects\HitPoints;
use App\Modules\Character\Domain\ValueObjects\Inventory;
use App\Modules\Character\Domain\ValueObjects\Reputation;
use App\Modules\Character\Domain\ValueObjects\Money;
use App\Modules\Character\Domain\ValueObjects\Statistics;
use App\Modules\Equipment\Domain\Entities\Item;
use App\Modules\Equipment\Domain\ValueObjects\ItemEffect;
use App\Modules\Equipment\Domain\ValueObjects\ItemType;
use App\Modules\Image\Domain\Entities\Image;
use App\Traits\ThrowsDice;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Character
{
    use ThrowsDice;

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
     * @var Race
     */
    private $race;
    /**
     * @var Location
     */
    private $location;
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
     * @var User|null
     */
    private $user;
    /**
     * @var Image|null
     */
    private $profilePicture;
    /**
     * @var Collection
     */
    private $items;
    /**
     * @var Carbon
     */
    private $createdAt;
    /**
     * @var Carbon
     */
    private $updatedAt;

    public function __construct(
        string $id,
        Race $race,
        int $levelId,
        Location $location,
        string $name,
        Gender $gender,
        int $xp,
        Money $money,
        Reputation $reputation,
        Attributes $attributes,
        HitPoints $hitPoints,
        Statistics $statistics,
        ?User $user
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->gender = $gender;
        $this->levelId = $levelId;
        $this->race = $race;
        $this->location = $location;
        $this->xp = $xp;
        $this->money = $money;
        $this->reputation = $reputation;
        $this->attributes = $attributes;
        $this->hitPoints = $hitPoints;
        $this->statistics = $statistics;
        $this->user = $user;
        $this->items = new ArrayCollection();
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();
    }

    public function getLevelNumber(): int
    {
        return $this->levelId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function generateDamage(): int
    {
        return self::throwOneDice() + $this->getBaseDamage();
    }

    public function getBaseDamage(): int
    {
        return $this->getStrength()
            + $this->getInventory()->getEquippedItemsEffect(ItemEffect::DAMAGE);
    }

    public function generatePrecision(): int
    {
        return self::throwTwoDices() + $this->getBasePrecision();
    }

    public function getBasePrecision(): int
    {
        return $this->getAgility()
            + $this->getInventory()->getEquippedItemsEffect(ItemEffect::PRECISION);
    }

    public function generateEvasionFactor(): int
    {
        return self::throwTwoDices() + $this->getBaseEvasion();
    }

    public function getBaseEvasion(): int
    {
        return $this->getAgility()
            + $this->getInventory()->getEquippedItemsEffect(ItemEffect::EVASION);
    }

    public function generateTrickery(): int
    {
        return self::throwOneDice() + $this->getBaseTrickery();
    }

    public function getBaseTrickery(): int
    {
        return $this->getIntelligence()
            + $this->getInventory()->getEquippedItemsEffect(ItemEffect::TRICKERY);
    }

    public function generateAwareness(): int
    {
        return self::throwTreeDices() + $this->getBaseAwareness();
    }

    public function getBaseAwareness(): int
    {
        return $this->getIntelligence() * 2
            + $this->getInventory()->getEquippedItemsEffect(ItemEffect::AWARENESS);
    }

    public function getArmorRating()
    {
        return $this->getInventory()->getEquippedItemsEffect(ItemEffect::ARMOR);
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
        return $this->attributes->getUnassigned();
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getHitPoints(): int
    {
        return $this->hitPoints->getHitPoints();
    }

    public function getTotalHitPoints(): int
    {
        return $this->hitPoints->getTotalHitPoints();
    }

    public function equals(Character $other): bool
    {
        return $this->getName() === $other->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function getXp(): int
    {
        return $this->xp;
    }

    public function getRace(): Race
    {
        return $this->race;
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
        $this->attributes = $this->attributes->assignAvailablePoint($attribute);

        if ($attribute === 'constitution') {
            $this->hitPoints = $this->hitPoints->withIncrementedConstitution();
        }
    }

    public function addItemToInventorySlot(int $slot, Item $item)
    {
        $this->items = $this->getInventory()->withAddedItem($slot, $item)->getItems();
    }

    public function addItemToInventory(Item $item)
    {
        $this->items = $this->getInventory()->withAddedItemToFreeSlot($item)->getItems();
    }

    public function setLocation(Location $location)
    {
        $this->location = $location;
    }

    public function isAlive(): bool
    {
        return $this->hitPoints->getHitPoints() > 0;
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
        return $this->statistics->getBattlesWon();
    }

    public function getBattlesLost(): int
    {
        return $this->statistics->getBattlesLost();
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

    public function hasProfilePicture(): bool
    {
        return isset($this->profilePicture);
    }

    public function setProfilePicture(Image $profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    public function getProfilePicture(): ?Image
    {
        return $this->profilePicture;
    }

    public function removeProfilePicture()
    {
        $this->profilePicture = null;
    }

    public function getInventory(): Inventory
    {
        return Inventory::withItems($this->items);
    }

    public function getProfilePictureFull(): string
    {
        if ($this->getProfilePicture())
        {
            return $this->getProfilePicture()->getFullSizeFile()->getFileName();
        }

        return $this->race->getImageByGender($this->gender);
    }

    public function isYou(int $userId): bool
    {
        return $this->isPlayerCharacter() && $this->user->getId() === $userId;
    }

    public function isPlayerCharacter(): bool
    {
        return !is_null($this->user);
    }

    public function isNPC(): bool
    {
        return !$this->isPlayerCharacter();
    }

    public function getHeadGearItem()
    {
        return Inventory::withItems($this->items)->findEquippedItemOfType(ItemType::headGear());
    }

    public function getBodyArmorItem()
    {
        return Inventory::withItems($this->items)->findEquippedItemOfType(ItemType::bodyArmor());
    }

    public function getMainHandItem()
    {
        return Inventory::withItems($this->items)->findEquippedItemOfType(ItemType::mainHand());
    }

    public function getOffHandItem()
    {
        return Inventory::withItems($this->items)->findEquippedItemOfType(ItemType::offHand());
    }
}

<?php


namespace App\Modules\Character\Domain;

use App\Modules\Equipment\Domain\Inventory;
use App\Modules\Equipment\Domain\Item;
use App\Modules\Equipment\Domain\ItemEffect;
use App\Modules\Equipment\Domain\Money;
use App\Modules\Image\Domain\ImageId;
use App\Traits\ThrowsDice;

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
     * @var CharacterType
     */
    private $type;
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
     * @var CharacterId
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
     * @var ImageId
     */
    private $profilePictureId;

    public function __construct(
        CharacterId $id,
        int $raceId,
        int $levelId,
        string $locationId,
        string $name,
        Gender $gender,
        CharacterType $type,
        int $xp,
        Reputation $reputation,
        Attributes $attributes,
        HitPoints $hitPoints,
        Statistics $statistics,
        Inventory $inventory,
        int $userId = null,
        ImageId $profilePictureId = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->gender = $gender;
        $this->type = $type;
        $this->levelId = $levelId;
        $this->raceId = $raceId;
        $this->locationId = $locationId;
        $this->xp = $xp;
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

    public function getId(): CharacterId
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
            + $this->inventory->getEquippedItemsEffect(ItemEffect::DAMAGE);
    }

    public function generatePrecision(): int
    {
        return self::throwTwoDices() + $this->getBasePrecision();
    }

    public function getBasePrecision(): int
    {
        return $this->getAgility()
            + $this->inventory->getEquippedItemsEffect(ItemEffect::PRECISION);
    }

    public function generateEvasionFactor(): int
    {
        return self::throwTwoDices() + $this->getBaseEvasion();
    }

    public function getBaseEvasion(): int
    {
        return $this->getAgility()
            + $this->inventory->getEquippedItemsEffect(ItemEffect::EVASION);
    }

    public function generateTrickery(): int
    {
        return self::throwOneDice() + $this->getBaseTrickery();
    }

    public function getBaseTrickery(): int
    {
        return $this->getIntelligence()
            + $this->inventory->getEquippedItemsEffect(ItemEffect::TRICKERY);
    }

    public function generateAwareness(): int
    {
        return self::throwTreeDices() + $this->getBaseAwareness();
    }

    public function getBaseAwareness(): int
    {
        return $this->getIntelligence() * 2
            + $this->inventory->getEquippedItemsEffect(ItemEffect::AWARENESS);
    }

    public function getArmorRating(): int
    {
        return $this->inventory->getEquippedItemsEffect(ItemEffect::ARMOR);
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
        return $this->getId()->equals($other->getId());
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserId(): ?int
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
        return $this->inventory->getMoney();
    }

    public function getReputation(): Reputation
    {
        return $this->reputation;
    }

    public function applyAttributeIncrease(string $attribute): void
    {
        if ($this->attributes->hasAvailablePoints()) {

            $this->attributes = $this->attributes->assignAvailablePoint($attribute);

            if ($attribute === 'constitution') {
                $this->hitPoints = $this->hitPoints->withIncrementedConstitution();
            }
        }
    }

    public function addItemToInventory(Item $item): void
    {
        $this->inventory->add($item);
    }

    public function setLocationId(string $locationId): void
    {
        $this->locationId = $locationId;
    }

    public function isAlive(): bool
    {
        return $this->hitPoints->getCurrentHitPoints() > 0;
    }

    public function incrementWonBattles(): void
    {
        $this->statistics = $this->statistics->withIncreaseWonBattles();
    }

    public function incrementLostBattles(): void
    {
        $this->statistics = $this->statistics->withIncreaseLostBattles();
    }

    public function addXp(int $xp): void
    {
        $this->xp += $xp;
    }

    public function getBattlesWon(): int
    {
        return $this->statistics->getBattlesWon();
    }

    public function getBattlesLost(): int
    {
        return $this->statistics->getBattlesLost();
    }

    public function applyDamage($damageDone): void
    {
        $this->hitPoints = $this->hitPoints->withUpdatedCurrentValue(-$damageDone);
    }

    public function updateLevel(int $levelId): void
    {
        $points = $levelId - $this->levelId;

        $this->levelId = $levelId;

        $this->attributes = $this->attributes->addAvailablePoints($points);
    }

    public function setProfilePictureId(ImageId $profilePictureId): void
    {
        $this->profilePictureId = $profilePictureId;
    }

    /**
     * @return ImageId|null
     */
    public function getProfilePictureId(): ?ImageId
    {
        return $this->profilePictureId;
    }

    public function removeProfilePicture(): void
    {
        $this->profilePictureId = null;
    }

    public function getInventory(): Inventory
    {
        return $this->inventory;
    }

    public function isMerchant(): bool
    {
        return $this->type->isMerchant();
    }
}

<?php


namespace App\Modules\Character\Domain\Entities;

use App\Modules\Character\Domain\ValueObjects\HitPoints;
use App\Modules\Character\Domain\ValueObjects\Reputation;
use App\Modules\Character\Domain\ValueObjects\Xp;
use App\Modules\Character\Domain\ValueObjects\Money;
use App\Character as CharacterModel;

class Character
{
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
     * @var int
     */
    private $locationId;
    /**
     * @var Xp
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
     * @var string
     */
    private $userId;
    /**
     * @var CharacterModel
     */
    private $characterModel;

    public function __construct(
        string $id,
        string $userId,
        int $raceId,
        int $levelId,
        int $locationId,
        string $name,
        Gender $gender,
        Xp $xp,
        Money $money,
        Reputation $reputation,
        Attributes $attributes,
        HitPoints $hitPoints
    )
    {
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
        $this->id = $id;
        $this->userId = $userId;
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
        return $this->attributes->get('strength');
    }

    public function getAgility(): int
    {
        return $this->attributes->get('agility');
    }

    public function getConstitution(): int
    {
        return $this->attributes->get('constitution');
    }

    public function getIntelligence(): int
    {
        return $this->attributes->get('intelligence');
    }

    public function getCharisma(): int
    {
        return $this->attributes->get('charisma');
    }

    public function getUnassignedAttributePoints(): int
    {
        return $this->attributes->get('unassigned');
    }

    public function getLocationId(): int
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

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function getXp(): Xp
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

    public function applyAttributeIncrease(string $attribute): Character
    {
        $unassignedPoints = $this->attributes->get('unassigned');
        $attributeValue = $this->attributes->get($attribute);

        if ($unassignedPoints) {

            $this->attributes->offsetSet('unassigned', $unassignedPoints - 1);
            $this->attributes->offsetSet($attribute, $attributeValue + 1);

            if ($attribute === 'constitution') {
                $this->hitPoints = HitPoints::incremented($this->hitPoints);
            }
        }

        return $this;
    }

    // Todo: temporary hack of having reference to the Eloquent model
    public function setCharacterModel(CharacterModel $characterModel)
    {
        $this->characterModel = $characterModel;
    }

    public function getCharacterModel(): CharacterModel
    {
        return $this->characterModel;
    }
}
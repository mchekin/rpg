<?php


namespace App\Modules\Battle\Domain\Entities;

use App\Modules\Battle\Domain\ValueObjects\BattleTurnResult;
use App\Modules\Character\Domain\Entities\Character;
use App\Traits\ThrowsDice;


class BattleTurn
{
    use ThrowsDice;

    /**
     * @var string
     */
    private $id;

    /**
     * @var Character
     */
    private $owner;

    /**
     * @var Character
     */
    private $target;

    /**
     * @var BattleTurnResult
     */
    private $result;

    public function __construct(string  $id, Character $owner, Character $target, BattleTurnResult $result)
    {
        $this->id = $id;
        $this->owner = $owner;
        $this->target = $target;
        $this->result = $result;
    }

    public function execute()
    {
        if (!$this->isTargetHit())
        {
            $this->result = BattleTurnResult::miss();
        }

        $damageDone = self::throwOneDice() + $this->owner->getStrength();

        $this->result = BattleTurnResult::hit($damageDone);

        if ($this->isCriticalHit())
        {
            $damageDone *= 3;

            $this->result = BattleTurnResult::criticalHit($damageDone);
        }

        $this->target->applyDamage($damageDone);
    }

    public function isOwnerAlive(): bool
    {
        return $this->owner->isAlive();
    }

    public function isTargetAlive(): bool
    {
        return $this->target->isAlive();
    }

    private function isTargetHit(): bool
    {
        $attackFactor = self::throwTwoDices() + $this->owner->getAgility();
        $defenceFactor = self::throwTwoDices() + $this->target->getAgility();

        return $attackFactor > $defenceFactor;
    }

    private function isCriticalHit(): bool
    {
        $attackFactor = self::throwOneDice() + $this->owner->getIntelligence();
        $defenceFactor = self::throwTwoDices() + $this->target->getIntelligence();

        return $attackFactor > $defenceFactor;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getOwner(): Character
    {
        return $this->owner;
    }

    public function getTarget(): Character
    {
        return $this->target;
    }

    public function getDamageDone(): int
    {
        return $this->result->getDamageDone();
    }

    public function getResultType(): string
    {
        return $this->result->getType();
    }
}
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

        $damage = $this->calculateDamage();

        if ($this->isCriticalHit())
        {
            $damage *= 3;

            $this->result = BattleTurnResult::criticalHit($damage);
        }
        else {
            $this->result = BattleTurnResult::hit($damage);
        }

        $this->target->applyDamage($damage);
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
        $precision = $this->owner->generatePrecisionFactor();
        $evasion = $this->target->generateEvasionFactor();

        return $precision > $evasion;
    }

    private function isCriticalHit(): bool
    {
        $trickery = $this->owner->generateTrickeryFactor() ;
        $awareness = $this->target->generateAwarenessFactor();

        return $trickery > $awareness;
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

    private function calculateDamage(): int
    {
        $forceFactor = $this->owner->generateForceFactor();
        $armorRating = $this->target->getArmorRating();

        $damageDone = $forceFactor - $armorRating;
        return $damageDone;
    }
}
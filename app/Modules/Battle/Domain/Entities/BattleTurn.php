<?php


namespace App\Modules\Battle\Domain\Entities;

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
     * @var int
     */
    private $damageDone;

    public function __construct(string  $id, Character $owner, Character $target)
    {
        $this->id = $id;
        $this->owner = $owner;
        $this->target = $target;
    }

    public function execute()
    {
        $attackForce = self::throwOneDice() + $this->owner->getStrength();

        if ($this->isTargetHit()) {

            $this->damageDone = $attackForce;

            $this->target->applyDamage($this->damageDone);
        }
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
        $attackFactor = self::throwOneDice() + $this->owner->getAgility();
        $defenceFactor = self::throwOneDice() + $this->target->getAgility();

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
        return (int)$this->damageDone;
    }
}
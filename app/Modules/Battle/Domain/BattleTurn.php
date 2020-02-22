<?php


namespace App\Modules\Battle\Domain;

use App\Modules\Character\Domain\Character;
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

    public function __construct(string $id, Character $owner, Character $target, BattleTurnResult $result)
    {
        $this->id = $id;
        $this->owner = $owner;
        $this->target = $target;
        $this->result = $result;
    }

    public function execute()
    {
        if (!$this->isTargetHit()) {
            $this->result = BattleTurnResult::miss();
        }

        $forceFactor = $this->owner->generateDamage();
        $armorRating = $this->target->getArmorRating();

        $isCriticalHit = $this->isCriticalHit();

        $forceFactor = $isCriticalHit ? $forceFactor * 3 : $forceFactor;

        $damage = max($forceFactor - $armorRating, 0);
        $damageAbsorbed = $forceFactor - $damage;

        $this->result = $isCriticalHit
            ? BattleTurnResult::criticalHit($damage, $damageAbsorbed)
            : BattleTurnResult::hit($damage, $damageAbsorbed);

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
        $precision = $this->owner->generatePrecision();
        $evasion = $this->target->generateEvasionFactor();

        return $precision > $evasion;
    }

    private function isCriticalHit(): bool
    {
        $trickery = $this->owner->generateTrickery();
        $awareness = $this->target->generateAwareness();

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

    public function getDamageAbsorbed(): int
    {
        return $this->result->getDamageAbsorbed();
    }

    public function getResultType(): string
    {
        return $this->result->getType();
    }
}

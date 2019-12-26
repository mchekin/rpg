<?php


namespace App\Modules\Battle\Domain\Entities;

use App\Modules\Battle\Domain\ValueObjects\BattleTurnResult;
use App\Modules\Character\Domain\Entities\Character;
use App\Traits\ThrowsDice;
use Carbon\Carbon;


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
    private $executor;

    /**
     * @var Character
     */
    private $target;

    /**
     * @var BattleTurnResult
     */
    private $result;
    /**
     * @var Carbon
     */
    private $createdAt;
    /**
     * @var Carbon
     */
    private $updatedAt;
    /**
     * @var string
     */
    private $battleRoundId;

    public function __construct(
        string $id,
        string $battleRoundId,
        Character $executor,
        Character $target,
        BattleTurnResult $result
    ) {
        $this->id = $id;
        $this->battleRoundId = $battleRoundId;
        $this->executor = $executor;
        $this->target = $target;
        $this->result = $result;
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();
    }

    public function execute()
    {
        if (!$this->isTargetHit()) {
            $this->result = BattleTurnResult::miss();
        }

        $forceFactor = $this->executor->generateDamage();
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
        return $this->executor->isAlive();
    }

    public function isTargetAlive(): bool
    {
        return $this->target->isAlive();
    }

    private function isTargetHit(): bool
    {
        $precision = $this->executor->generatePrecision();
        $evasion = $this->target->generateEvasionFactor();

        return $precision > $evasion;
    }

    private function isCriticalHit(): bool
    {
        $trickery = $this->executor->generateTrickery();
        $awareness = $this->target->generateAwareness();

        return $trickery > $awareness;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getExecutor(): Character
    {
        return $this->executor;
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

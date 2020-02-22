<?php


namespace App\Modules\Battle\Domain;


class BattleTurnResult
{
    const NONE = 'none';
    const MISS = 'miss';
    const HIT = 'hit';
    const CRITICAL_HIT = 'critical_hit';

    const TYPES = [
        self::NONE,
        self::MISS,
        self::HIT,
        self::CRITICAL_HIT,
    ];

    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $damageDone;

    /**
     * @var int
     */
    private $damageAbsorbed;

    public function __construct(string $type, int $damageDone, int $damageAbsorbed)
    {
        $this->type = $type;
        $this->damageDone = $damageDone;
        $this->damageAbsorbed = $damageAbsorbed;
    }

    public static function none()
    {
        return new self(self::NONE, 0, 0);
    }

    public static function miss()
    {
        return new self(self::MISS, 0, 0);
    }

    public static function hit(int $damageDone, int $damageAbsorbed)
    {
        return new self(self::HIT, $damageDone, $damageAbsorbed);
    }

    public static function criticalHit(int $damageDone, int $damageAbsorbed)
    {
        return new self(self::CRITICAL_HIT, $damageDone, $damageAbsorbed);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDamageDone(): int
    {
        return $this->damageDone;
    }

    public function getDamageAbsorbed(): int
    {
        return $this->damageAbsorbed;
    }
}

<?php


namespace App\Modules\Battle\Domain\ValueObjects;


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
     * @var int
     */
    private $damageDone;
    /**
     * @var string
     */
    private $type;

    public function __construct(int $damageDone, string $type)
    {
        $this->damageDone = $damageDone;
        $this->type = $type;
    }

    public static function none()
    {
        return new self(0, self::NONE);
    }

    public static function miss()
    {
        return new self(0, self::MISS);
    }

    public static function hit(int $damageDone)
    {
        return new self($damageDone, self::HIT);
    }

    public static function criticalHit(int $damageDone)
    {
        return new self($damageDone, self::CRITICAL_HIT);
    }

    public function getDamageDone(): int
    {
        return $this->damageDone;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
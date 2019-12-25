<?php


namespace App\Modules\Character\Domain\ValueObjects;


use App\Modules\Character\Domain\Entities\Race;
use App\Traits\ThrowsDice;

class HitPoints
{
    use ThrowsDice;

    /**
     * @var int
     */
    private $hitPoints;

    /**
     * @var int
     */
    private $totalHitPoints;

    public static function byRace(Race $race): HitPoints
    {
        $maximumHitPoints = self::constitutionToHitPoints($race->getConstitution());

        return new HitPoints($maximumHitPoints, $maximumHitPoints);
    }

    public function withIncrementedConstitution(): HitPoints
    {
        return new HitPoints(
            $this->hitPoints,
            $this->totalHitPoints + self::constitutionToHitPoints(1)
        );
    }

    public function withUpdatedCurrentValue(int $points): HitPoints
    {
        return new HitPoints(
            $this->hitPoints + $points,
            $this->totalHitPoints
        );
    }

    protected static function constitutionToHitPoints(int $constitutionPoints): int
    {
        return $constitutionPoints * 10 + self::throwTwoDices();
    }

    public function __construct(int $hitPoints, int $totalHitPoints)
    {
        $this->hitPoints = $hitPoints;
        $this->totalHitPoints = $totalHitPoints;
    }

    public function getHitPoints(): int
    {
        return $this->hitPoints;
    }

    public function getTotalHitPoints(): int
    {
        return $this->totalHitPoints;
    }
}

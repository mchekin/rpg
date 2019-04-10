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
    private $currentHitPoints;

    /**
     * @var int
     */
    private $maximumHitPoints;

    public static function generatedByRace(Race $race): HitPoints
    {
        $maximumHitPoints =  self::constitutionToHitPoints($race->getConstitution());

        return new HitPoints($maximumHitPoints, $maximumHitPoints);
    }

    public static function incremented(HitPoints $hitPoints): HitPoints
    {
        $maximumHitPoints = $hitPoints->getMaximumHitPoints() + self::constitutionToHitPoints(1);

        return new HitPoints(
            $hitPoints->getCurrentHitPoints(),
            $maximumHitPoints
        );
    }

    protected static function constitutionToHitPoints(int $constitutionPoints): int
    {
        return $constitutionPoints * 10 + self::throwTwoDices();
    }

    public function __construct(int $currentHitPoints, int $maximumHitPoints)
    {
        $this->currentHitPoints = $currentHitPoints;
        $this->maximumHitPoints = $maximumHitPoints;
    }

    public function getCurrentHitPoints(): int
    {
        return $this->currentHitPoints;
    }

    public function getMaximumHitPoints(): int
    {
        return $this->maximumHitPoints;
    }
}
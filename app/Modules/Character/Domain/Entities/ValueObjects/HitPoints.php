<?php


namespace App\Modules\Character\Domain\Entities\ValueObjects;


class HitPoints
{
    /**
     * @var int
     */
    private $currentHitPoints;

    /**
     * @var int
     */
    private $maximumHitPoints;

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
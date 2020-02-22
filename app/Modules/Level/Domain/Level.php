<?php


namespace App\Modules\Level\Domain;


class Level
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $currentLevelThreshold;
    /**
     * @var int
     */
    private $nextLevelThreshold;

    public function __construct(int $id, int $currentLevelThreshHold, int $nextLevelXpThreshold)
    {
        $this->id = $id;
        $this->currentLevelThreshold = $currentLevelThreshHold;
        $this->nextLevelThreshold = $nextLevelXpThreshold;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCurrentXpThreshold(): int
    {
        return $this->currentLevelThreshold;
    }

    public function getNextXpThreshold(): int
    {
        return $this->nextLevelThreshold;
    }

    public function getProgress(int $xp):float
    {
        $progressRange = $this->nextLevelThreshold - $this->currentLevelThreshold;

        $progressMade = $xp - $this->currentLevelThreshold;
        $progressMade = $progressMade < 0 ? 0 : $progressMade;

        return ($progressMade / $progressRange) * 100;
    }
}

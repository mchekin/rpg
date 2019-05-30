<?php


namespace App\Modules\Level\Domain\Entities;


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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCurrentXpThreshold(): int
    {
        return $this->currentLevelThreshold;
    }

    /**
     * @return int
     */
    public function getNextXpThreshold(): int
    {
        return $this->nextLevelThreshold;
    }
}
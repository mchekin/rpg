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
    private $nextLevelXpThreshold;

    public function __construct(int $id, int $nextLevelXpThreshold)
    {
        $this->id = $id;
        $this->nextLevelXpThreshold = $nextLevelXpThreshold;
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
    public function getNextLevelXpThreshold(): int
    {
        return $this->nextLevelXpThreshold;
    }
}
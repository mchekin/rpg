<?php

namespace App\Modules\Character\Domain\ValueObjects;

class Statistics
{
    /**
     * @var int
     */
    private $battlesWon;
    /**
     * @var int
     */
    private $battlesLost;

    public function __construct(int $battlesWon, int $battlesLost)
    {
        $this->battlesWon = $battlesWon;
        $this->battlesLost = $battlesLost;
    }

    public function withIncreaseWonBattles(): Statistics
    {
        return new self($this->battlesWon + 1, $this->battlesLost);
    }

    public function withIncreaseLostBattles(): Statistics
    {
        return new self($this->battlesWon, $this->battlesLost + 1);
    }

    public function getBattlesWon(): int
    {
        return $this->battlesWon;
    }

    public function getBattlesLost(): int
    {
        return $this->battlesLost;
    }
}

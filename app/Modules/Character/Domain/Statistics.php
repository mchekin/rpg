<?php


namespace App\Modules\Character\Domain;


use Illuminate\Support\Collection;

class Statistics
{
    private $statistics;

    public function __construct($statistics = [])
    {
        $this->statistics = new Collection($statistics);
    }

    public function withIncreaseWonBattles(): Statistics
    {
        $data = $this->statistics->all();

        $data['battlesWon']++;

        return new self($data);
    }

    public function withIncreaseLostBattles(): Statistics
    {
        $data = $this->statistics->all();

        $data['battlesLost']++;

        return new self($data);
    }

    public function getBattlesWon(): int
    {
        return (int)$this->statistics->get('battlesWon');
    }

    public function getBattlesLost(): int
    {
        return (int)$this->statistics->get('battlesLost');
    }
}

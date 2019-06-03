<?php


namespace App\Modules\Character\Domain\ValueObjects;


use Illuminate\Support\Collection;

class Statistics extends Collection
{
    public function __construct($items = [])
    {
        parent::__construct($items);
    }

    public function withIncreaseWonBattles(): Statistics
    {
        $data = $this->all();

        $data['battlesWon']++;

        return Statistics::make($data);
    }

    public function withIncreaseLostBattles(): Statistics
    {
        $data = $this->all();

        $data['battlesLost']++;

        return Statistics::make($data);
    }
}
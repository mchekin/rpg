<?php


namespace App\Modules\Battle\Domain\Factories;


use App\Modules\Battle\Domain\Entities\DiceRoll;

class DiceRollFactory
{
    public function create(): DiceRoll
    {
        return new DiceRoll(rand(1, 6));
    }
}
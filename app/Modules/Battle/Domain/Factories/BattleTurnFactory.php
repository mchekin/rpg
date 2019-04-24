<?php


namespace App\Modules\Battle\Domain\Factories;


use App\Modules\Battle\Domain\Entities\BattleTurn;
use App\Modules\Character\Domain\Entities\Character;
use App\Traits\GeneratesUuid;

class BattleTurnFactory
{
    use GeneratesUuid;

    public function create(Character $owner, Character $target): BattleTurn
    {
        return new BattleTurn(
            $this->generateUuid(),
            $owner,
            $target
        );
    }
}
<?php

namespace App\Modules\Trade\Application\Commands;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\Money;

class MoveMoneyToContainerCommand
{
    /**
     * @var Money
     */
    private $money;
    /**
     * @var CharacterId
     */
    private $characterId;

    public function __construct(Money $money, CharacterId $characterId)
    {
        $this->money = $money;
        $this->characterId = $characterId;
    }

    public function getMoney(): Money
    {
        return $this->money;
    }

    public function getCharacterId(): CharacterId
    {
        return $this->characterId;
    }
}

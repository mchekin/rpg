<?php


namespace App\Modules\Character\Application\Commands;


use App\Modules\Character\Domain\CharacterId;

class AttackCharacterCommand
{
    /**
     * @var CharacterId
     */
    private $attackerId;
    /**
     * @var CharacterId
     */
    private $defenderId;

    public function __construct(CharacterId $attackerId, CharacterId $defenderId)
    {
        $this->attackerId = $attackerId;
        $this->defenderId = $defenderId;
    }

    public function getAttackerId(): CharacterId
    {
        return $this->attackerId;
    }

    public function getDefenderId(): CharacterId
    {
        return $this->defenderId;
    }
}

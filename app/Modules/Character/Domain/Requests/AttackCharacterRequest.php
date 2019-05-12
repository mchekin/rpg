<?php


namespace App\Modules\Character\Domain\Requests;


class AttackCharacterRequest
{
    /**
     * @var string
     */
    private $attackerId;
    /**
     * @var string
     */
    private $defenderId;

    public function __construct(string $attackerId, string $defenderId)
    {
        $this->attackerId = $attackerId;
        $this->defenderId = $defenderId;
    }

    public function getAttackerId(): string
    {
        return $this->attackerId;
    }

    public function getDefenderId(): string
    {
        return $this->defenderId;
    }
}
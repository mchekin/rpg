<?php


namespace App\Modules\Battle\Domain\Entities;

use App\Modules\Battle\Domain\Factories\BattleTurnFactory;
use App\Modules\Battle\Domain\Entities\Collections\BattleTurns;
use App\Modules\Character\Domain\Entities\Character;

class BattleRound
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $battleId;

    /**
     * @var BattleTurnFactory
     */
    private $turnFactory;

    /**
     * @var Character
     */
    private $attacker;

    /**
     * @var Character
     */
    private $defender;

    /**
     * @var BattleTurns
     */
    private $turns;

    public function __construct(
        string $id,
        string $battleId,
        Character $attacker,
        Character $defender,
        BattleTurnFactory $turnFactory,
        BattleTurns $turns
    ) {
        $this->id = $id;
        $this->battleId = $battleId;
        $this->attacker = $attacker;
        $this->defender = $defender;
        $this->turnFactory = $turnFactory;
        $this->turns = $turns;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getBattleId(): string
    {
        return $this->battleId;
    }

    public function getTurns(): BattleTurns
    {
        return $this->turns;
    }

    public function execute()
    {
        $turn = $this->turnFactory->create($this->attacker, $this->defender);

        $turn->execute();

        $this->turns->push($turn);

        if (!$turn->isTargetAlive()) {
            return $turn;
        }

        $turn = $this->turnFactory->create($this->defender, $this->attacker);

        $turn->execute();

        $this->turns->push($turn);

        return $turn;
    }

    public function notLastRound(): bool
    {
        /** @var BattleTurn $lastTurn */
        $lastTurn = $this->turns->last();

        return $lastTurn->isTargetAlive();
    }
}
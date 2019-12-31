<?php


namespace App\Modules\Battle\Domain\Entities;

use App\Modules\Battle\Domain\Entities\Collections\BattleTurns;
use App\Modules\Battle\Domain\ValueObjects\BattleTurnResult;
use App\Modules\Character\Domain\Entities\Character;
use App\Traits\GeneratesUuid;

class BattleRound
{
    use GeneratesUuid;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $battleId;

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
        BattleTurns $turns
    ) {
        $this->id = $id;
        $this->battleId = $battleId;
        $this->attacker = $attacker;
        $this->defender = $defender;
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

    public function execute(): void
    {
        $turn = $this->createTurn($this->attacker, $this->defender);

        $turn->execute();

        $this->turns->push($turn);

        if ($turn->isTargetAlive()) {

            $turn = $this->createTurn($this->defender, $this->attacker);

            $turn->execute();

            $this->turns->push($turn);
        };
    }

    public function notLastRound(): bool
    {
        /** @var BattleTurn $lastTurn */
        $lastTurn = $this->turns->last();

        return $lastTurn->isTargetAlive();
    }

    private function createTurn(Character $owner, Character $target): BattleTurn
    {
        return new BattleTurn(
            $this->generateUuid(),
            $this->id,
            $owner,
            $target,
            BattleTurnResult::none()
        );
    }
}

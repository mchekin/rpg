<?php


namespace App\Modules\Battle\Domain;

use App\Modules\Character\Domain\Character;
use App\Traits\GeneratesUuid;

class BattleRound
{
    use GeneratesUuid;

    /**
     * @var string
     */
    private $id;

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
        Character $attacker,
        Character $defender,
        BattleTurns $turns
    ) {
        $this->id = $id;
        $this->attacker = $attacker;
        $this->defender = $defender;
        $this->turns = $turns;
    }

    public function getId(): string
    {
        return $this->id;
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
        }
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
            $owner,
            $target,
            BattleTurnResult::none()
        );
    }
}

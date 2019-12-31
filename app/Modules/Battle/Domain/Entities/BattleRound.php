<?php


namespace App\Modules\Battle\Domain\Entities;

use App\Modules\Battle\Domain\Entities\Collections\BattleTurns;
use App\Modules\Battle\Domain\ValueObjects\BattleTurnResult;
use App\Modules\Character\Domain\Entities\Character;
use App\Traits\GeneratesUuid;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var ArrayCollection
     */
    private $turns;

    /**
     * @var Carbon
     */
    private $createdAt;

    /**
     * @var Carbon
     */
    private $updatedAt;

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
        $this->turns = new ArrayCollection($turns->all());
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getBattleId(): string
    {
        return $this->battleId;
    }

    public function getTurns(): ArrayCollection
    {
        return $this->turns;
    }

    public function execute()
    {
        $turn = $this->createTurn($this->attacker, $this->defender);

        $turn->execute();

        $this->turns->add($turn);

        if (!$turn->isTargetAlive()) {
            return $turn;
        }

        $turn = $this->createTurn($this->defender, $this->attacker);

        $turn->execute();

        $this->turns->add($turn);

        return $turn;
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

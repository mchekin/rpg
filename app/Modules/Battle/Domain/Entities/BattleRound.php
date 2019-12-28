<?php


namespace App\Modules\Battle\Domain\Entities;

use App\Modules\Battle\Domain\Factories\BattleTurnFactory;
use App\Modules\Battle\Domain\Entities\Collections\BattleTurns;
use App\Modules\Character\Domain\Entities\Character;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;

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
        BattleTurnFactory $turnFactory,
        BattleTurns $turns
    ) {
        $this->id = $id;
        $this->battleId = $battleId;
        $this->attacker = $attacker;
        $this->defender = $defender;
        $this->turnFactory = $turnFactory;
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
        $turn = $this->turnFactory->create($this->attacker, $this->defender);

        $turn->execute();

        $this->turns->add($turn);

        if (!$turn->isTargetAlive()) {
            return $turn;
        }

        $turn = $this->turnFactory->create($this->defender, $this->attacker);

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
}

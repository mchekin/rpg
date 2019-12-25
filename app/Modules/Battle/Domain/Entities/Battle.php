<?php

namespace App\Modules\Battle\Domain\Entities;

use App\Modules\Battle\Domain\Factories\BattleRoundFactory;
use App\Modules\Battle\Domain\Entities\Collections\BattleRounds;
use App\Modules\Character\Domain\Entities\Character;
use App\Traits\ContainsModel;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;

class Battle
{
    // Todo: temporary hack of having reference to the Eloquent model
    use ContainsModel;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $locationId;

    /**
     * @var Character
     */
    private $attacker;

    /**
     * @var Character
     */
    private $defender;

    /**
     * @var BattleRoundFactory
     */
    private $roundFactory;

    /**
     * @var ArrayCollection
     */
    private $rounds;

    /**
     * @var int
     */
    private $victorXpGained;

    /**
     * @var Character|null
     */
    private $victor;
    /**
     * @var bool
     */
    private $seenByDefender;
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
        string $locationId,
        Character $attacker,
        Character $defender,
        BattleRoundFactory $roundFactory,
        BattleRounds $rounds,
        int $victorXpGained,
        Character $victor = null
    )
    {
        $this->id = $id;
        $this->locationId = $locationId;
        $this->attacker = $attacker;
        $this->defender = $defender;
        $this->roundFactory = $roundFactory;
        $this->rounds = new ArrayCollection($rounds->all());
        $this->victorXpGained = $victorXpGained;
        $this->victor = $victor;
        $this->seenByDefender = false;
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();
    }

    public function execute()
    {
        do {
            $round = $this->roundFactory->create(
                $this->getId(),
                $this->getAttacker(),
                $this->getDefender()
            );

            $round->execute();

            $this->rounds->add($round);

        } while ($round->notLastRound());

        $this->victor = $this->attacker->isAlive() ? $this->attacker : $this->defender;
        $loser = $this->attacker->isAlive() ? $this->defender : $this->attacker;

        $this->victorXpGained = $this->calculateVictorXpGained($loser, $this->victor);
    }

    protected function calculateVictorXpGained(Character $loser, Character $victor): int
    {
        return max($loser->getLevelNumber() - $victor->getLevelNumber(), 1) * 3;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAttacker(): Character
    {
        return $this->attacker;
    }

    public function getDefender(): Character
    {
        return $this->defender;
    }

    public function getVictorXpGained(): int
    {
        return $this->victorXpGained;
    }

    public function getRounds(): ArrayCollection
    {
        return $this->rounds;
    }

    public function getVictor(): Character
    {
        return $this->victor;
    }

    public function getLoser(): Character
    {
        return $this->victor->getId() === $this->attacker->getId() ? $this->defender : $this->attacker;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }
}

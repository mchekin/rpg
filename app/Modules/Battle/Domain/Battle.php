<?php

namespace App\Modules\Battle\Domain;

use App\Modules\Character\Domain\Character;
use App\Traits\GeneratesUuid;

class Battle
{
    use GeneratesUuid;

    /**
     * @var BattleId
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
     * @var BattleRounds
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

    public function __construct(
        BattleId $id,
        string $locationId,
        Character $attacker,
        Character $defender,
        BattleRounds $rounds,
        int $victorXpGained,
        Character $victor = null
    )
    {
        $this->id = $id;
        $this->locationId = $locationId;
        $this->attacker = $attacker;
        $this->defender = $defender;
        $this->rounds = $rounds;
        $this->victorXpGained = $victorXpGained;
        $this->victor = $victor;
    }

    public function execute(): void
    {
        do {
            $round = $this->createRound(
                $this->getAttacker(),
                $this->getDefender()
            );

            $round->execute();

            $this->rounds->push($round);

        } while ($round->notLastRound());

        $this->victor = $this->attacker->isAlive() ? $this->attacker : $this->defender;
        $loser = $this->attacker->isAlive() ? $this->defender : $this->attacker;

        $this->victorXpGained = $this->calculateVictorXpGained($loser, $this->victor);
    }

    private function calculateVictorXpGained(Character $loser, Character $victor): int
    {
        return max($loser->getLevelNumber() - $victor->getLevelNumber(), 1) * 3;
    }

    public function getId(): BattleId
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

    public function getRounds(): BattleRounds
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

    private function createRound(Character $attacker, Character $defender): BattleRound
    {
        return new BattleRound(
            $this->generateUuid(),
            $attacker,
            $defender,
            new BattleTurns()
        );
    }
}

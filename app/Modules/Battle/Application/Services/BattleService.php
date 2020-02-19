<?php


namespace App\Modules\Battle\Application\Services;


use App\Modules\Battle\Application\Contracts\BattleRepositoryInterface;
use App\Modules\Battle\Domain\Entities\Battle;
use App\Modules\Battle\Domain\Entities\Collections\BattleRounds;
use App\Modules\Character\Domain\Entities\Character;
use App\Traits\GeneratesUuid;

class BattleService
{
    use GeneratesUuid;

    /**
     * @var BattleRepositoryInterface
     */
    private $battleRepository;

    public function __construct(BattleRepositoryInterface $battleRepository)
    {
        $this->battleRepository = $battleRepository;
    }

    public function create(Character $attacker, Character $defender): Battle
    {
        $battle = new Battle(
            $this->generateUuid(),
            $defender->getLocationId(),
            $attacker,
            $defender,
            new BattleRounds(),
            0
        );

        $battle->execute();

        $this->battleRepository->add($battle);

        return $battle;
    }
}

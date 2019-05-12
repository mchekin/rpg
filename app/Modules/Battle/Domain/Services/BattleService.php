<?php


namespace App\Modules\Character\Domain\Services;


use App\Modules\Battle\Domain\Contracts\BattleRepositoryInterface;
use App\Modules\Battle\Domain\Entities\Battle;
use App\Modules\Battle\Domain\Factories\BattleFactory;
use App\Modules\Character\Domain\Contracts\CharacterRepositoryInterface;
use App\Modules\Character\Domain\Entities\Character;

class BattleService
{
    /**
     * @var BattleFactory
     */
    private $battleFactory;
    /**
     * @var CharacterRepositoryInterface
     */
    private $characterRepository;
    /**
     * @var BattleRepositoryInterface
     */
    private $battleRepository;

    public function __construct(
        BattleFactory $battleFactory,
        CharacterRepositoryInterface $characterRepository,
        BattleRepositoryInterface $battleRepository
    ) {
        $this->battleFactory = $battleFactory;
        $this->characterRepository = $characterRepository;
        $this->battleRepository = $battleRepository;
    }

    public function create(Character $attacker, Character $defender): Battle
    {
        $battle = $this->battleFactory->create($attacker, $defender);

        $battle->execute();

        $this->battleRepository->add($battle);

        return $battle;
    }
}
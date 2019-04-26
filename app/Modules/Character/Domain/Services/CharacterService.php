<?php


namespace App\Modules\Character\Domain\Services;


use App\Modules\Battle\Domain\Entities\Battle;
use App\Modules\Character\Domain\Contracts\CharacterRepositoryInterface;
use App\Modules\Character\Domain\Factories\CharacterFactory;
use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Character\Domain\Requests\AttackCharacterRequest;
use App\Modules\Character\Domain\Requests\CreateCharacterRequest;
use App\Modules\Character\Domain\Requests\IncreaseAttributeRequest;
use App\Modules\Character\Domain\Requests\MoveCharacterRequest;
use App\Modules\Level\Domain\Services\LevelService;
use Illuminate\Support\Facades\DB;

class CharacterService
{
    /**
     * @var CharacterFactory
     */
    private $characterFactory;
    /**
     * @var CharacterRepositoryInterface
     */
    private $characterRepository;
    /**
     * @var BattleService
     */
    private $battleService;
    /**
     * @var LevelService
     */
    private $levelService;

    public function __construct(
        CharacterFactory $characterFactory,
        CharacterRepositoryInterface $characterRepository,
        BattleService $battleService,
        LevelService $levelService
    ) {
        $this->characterFactory = $characterFactory;
        $this->characterRepository = $characterRepository;
        $this->battleService = $battleService;
        $this->levelService = $levelService;
    }

    public function create(CreateCharacterRequest $request): Character
    {
        $character = $this->characterFactory->create($request);

        $this->characterRepository->add($character);

        return $character;
    }

    public function getOne(string $characterId): Character
    {
        return $this->characterRepository->getOne($characterId);
    }

    public function increaseAttribute(IncreaseAttributeRequest $request)
    {
        $character = $this->characterRepository->getOne($request->getCharacterId());

        $character->applyAttributeIncrease($request->getAttribute());

        $this->characterRepository->update($character);
    }

    public function move(MoveCharacterRequest $request)
    {
        $character = $this->characterRepository->getOne($request->getCharacterId());

        $character->setLocationId($request->getLocationId());

        $this->characterRepository->update($character);
    }

    public function attack(AttackCharacterRequest $request): Battle
    {
        return DB::transaction(function () use ($request) {

            $attacker = $this->characterRepository->getOne($request->getAttackerId());
            $defender = $this->characterRepository->getOne($request->getDefenderId());

            $battle = $this->battleService->create($attacker, $defender);

            $victor = $battle->getVictor();
            $loser = $battle->getLoser();

            $victor->incrementWonBattles();
            $loser->incrementLostBattles();

            $victor->addXp($battle->getVictorXpGained());

            $newLevel = $this->levelService->getLevelByXp($victor->getXp());

            $victor->updateLevel($newLevel->getId());

            $this->characterRepository->update($victor);
            $this->characterRepository->update($loser);

            return $battle;
        });
    }
}
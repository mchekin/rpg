<?php


namespace App\Modules\Character\Domain\Services;


use App\Modules\Battle\Domain\Entities\Battle;
use App\Modules\Character\Domain\Contracts\CharacterRepositoryInterface;
use App\Modules\Character\Domain\Factories\CharacterFactory;
use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Character\Domain\Commands\AttackCharacterCommand;
use App\Modules\Character\Domain\Commands\CreateCharacterCommand;
use App\Modules\Character\Domain\Commands\IncreaseAttributeCommand;
use App\Modules\Character\Domain\Commands\MoveCharacterCommand;
use App\Modules\Image\Domain\Entities\Image;
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

    public function create(CreateCharacterCommand $command): Character
    {
        $character = $this->characterFactory->create($command);

        $this->characterRepository->add($character);

        return $character;
    }

    public function getOne(string $characterId): Character
    {
        return $this->characterRepository->getOne($characterId);
    }

    public function increaseAttribute(IncreaseAttributeCommand $command)
    {
        $character = $this->characterRepository->getOne($command->getCharacterId());

        $character->applyAttributeIncrease($command->getAttribute());

        $this->characterRepository->update($character);
    }

    public function move(MoveCharacterCommand $command)
    {
        $character = $this->characterRepository->getOne($command->getCharacterId());

        $character->setLocationId($command->getLocationId());

        $this->characterRepository->update($character);
    }

    public function attack(AttackCharacterCommand $command): Battle
    {
        return DB::transaction(function () use ($command) {

            $attacker = $this->characterRepository->getOne($command->getAttackerId());
            $defender = $this->characterRepository->getOne($command->getDefenderId());

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

    public function updateProfilePicture(Image $picture)
    {
        $character = $this->characterRepository->getOne($picture->getCharacterId());

        $character->setProfilePictureId($picture->getId());

        $this->characterRepository->update($character);
    }

    public function removeProfilePicture(string $characterId)
    {
        $character = $this->characterRepository->getOne($characterId);

        $character->removeProfilePicture();

        $this->characterRepository->update($character);
    }
}
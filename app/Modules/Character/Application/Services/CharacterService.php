<?php


namespace App\Modules\Character\Application\Services;


use App\Modules\Battle\Application\Contracts\BattleRepositoryInterface;
use App\Modules\Battle\Domain\Battle;
use App\Modules\Battle\Domain\BattleId;
use App\Modules\Battle\Domain\BattleRounds;
use App\Modules\Character\Application\Contracts\RaceRepositoryInterface;
use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Application\Commands\AddItemToInventoryCommand;
use App\Modules\Character\Application\Contracts\CharacterRepositoryInterface;
use App\Modules\Character\Domain\Character;
use App\Modules\Character\Application\Commands\AttackCharacterCommand;
use App\Modules\Character\Application\Commands\CreateCharacterCommand;
use App\Modules\Character\Application\Commands\IncreaseAttributeCommand;
use App\Modules\Character\Application\Commands\MoveCharacterCommand;
use App\Modules\Character\Application\Factories\CharacterFactory;
use App\Modules\Equipment\Application\Commands\EquipItemCommand;
use App\Modules\Equipment\Application\Contracts\ItemRepositoryInterface;
use App\Modules\Equipment\Domain\Item;
use App\Modules\Image\Domain\Image;
use App\Modules\Level\Application\Services\LevelService;
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
     * @var ItemRepositoryInterface
     */
    private $itemRepository;
    /**
     * @var RaceRepositoryInterface
     */
    private $raceRepository;
    /**
     * @var BattleRepositoryInterface
     */
    private $battleRepository;
    /**
     * @var LevelService
     */
    private $levelService;

    public function __construct(
        CharacterFactory $characterFactory,
        CharacterRepositoryInterface $characterRepository,
        ItemRepositoryInterface $itemRepository,
        RaceRepositoryInterface $raceRepository,
        BattleRepositoryInterface $battleRepository,
        LevelService $levelService
    )
    {
        $this->characterFactory = $characterFactory;
        $this->characterRepository = $characterRepository;
        $this->itemRepository = $itemRepository;
        $this->raceRepository = $raceRepository;
        $this->battleRepository = $battleRepository;
        $this->levelService = $levelService;
    }

    public function create(CreateCharacterCommand $command): Character
    {
        $characterId = $this->characterRepository->nextIdentity();
        $race = $this->raceRepository->getOne($command->getRaceId());

        $character = $this->characterFactory->create($characterId, $command, $race);

        $this->characterRepository->add($character);

        return $character;
    }

    public function equipItem(EquipItemCommand $command): void
    {
        $item = $this->itemRepository->getOne($command->getItemId());
        $character = $this->characterRepository->getOne($command->getOwnerCharacterId());

        if (!$item->isEquipped() && $character->getInventory()->hasItem($item)) {
            $equippedItem = $character->getInventory()->findEquippedItemOfType($item->getType());

            if ($equippedItem !== null) {
                /** @var Item $equippedItem */
                $equippedItem->unEquip();
                $this->itemRepository->update($equippedItem);
            }

            $item->equip();

            $this->itemRepository->update($item);
            $this->characterRepository->update($character);
        }
    }

    public function unEquipItem(EquipItemCommand $command): void
    {
        $item = $this->itemRepository->getOne($command->getItemId());
        $character = $this->characterRepository->getOne($command->getOwnerCharacterId());

        if ($item->isEquipped() && $character->getInventory()->hasItem($item)) {
            /** @var Item $item */
            $item->unEquip();
            $this->itemRepository->update($item);
        }
    }

    public function addItemToInventory(AddItemToInventoryCommand $command): Character
    {
        $character = $this->characterRepository->getOne($command->getCharacterId());
        $item = $this->itemRepository->getOne($command->getItemId());

        $character->addItemToInventorySlot($command->getSlot(), $item);

        $this->characterRepository->update($character);

        return $character;
    }

    public function increaseAttribute(IncreaseAttributeCommand $command): void
    {
        $character = $this->characterRepository->getOne($command->getCharacterId());

        $character->applyAttributeIncrease($command->getAttribute());

        $this->characterRepository->update($character);
    }

    public function move(MoveCharacterCommand $command): void
    {
        $character = $this->characterRepository->getOne($command->getCharacterId());

        $character->setLocationId($command->getLocationId());

        $this->characterRepository->update($character);
    }

    public function attack(AttackCharacterCommand $command): BattleId
    {
        return DB::transaction(function () use ($command) {

            $attacker = $this->characterRepository->getOne($command->getAttackerId());
            $defender = $this->characterRepository->getOne($command->getDefenderId());

            $battleId = $this->battleRepository->nextIdentity();

            $battle = new Battle(
                $battleId,
                $defender->getLocationId(),
                $attacker,
                $defender,
                new BattleRounds(),
                0
            );

            $battle->execute();

            $victor = $battle->getVictor();
            $loser = $battle->getLoser();

            $victor->incrementWonBattles();
            $loser->incrementLostBattles();

            $victor->addXp($battle->getVictorXpGained());

            $newLevel = $this->levelService->getLevelByXp($victor->getXp());

            $victor->updateLevel($newLevel->getId());

            $this->characterRepository->update($victor);
            $this->characterRepository->update($loser);
            $this->battleRepository->add($battle);

            return $battleId;
        });
    }

    public function updateProfilePicture(Image $picture): void
    {
        $character = $this->characterRepository->getOne($picture->getCharacterId());

        $character->setProfilePictureId($picture->getId());

        $this->characterRepository->update($character);
    }

    public function removeProfilePicture(CharacterId $characterId): void
    {
        $character = $this->characterRepository->getOne($characterId);

        $character->removeProfilePicture();

        $this->characterRepository->update($character);
    }
}

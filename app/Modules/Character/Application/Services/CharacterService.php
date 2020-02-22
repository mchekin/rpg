<?php


namespace App\Modules\Character\Application\Services;


use App\Modules\Battle\Application\Services\BattleService;
use App\Modules\Battle\Domain\Battle;
use App\Modules\Character\Application\Contracts\RaceRepositoryInterface;
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
use App\Traits\GeneratesUuid;
use Illuminate\Support\Facades\DB;

class CharacterService
{
    use GeneratesUuid;

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
        ItemRepositoryInterface $itemRepository,
        RaceRepositoryInterface $raceRepository,
        BattleService $battleService,
        LevelService $levelService
    )
    {
        $this->characterFactory = $characterFactory;
        $this->characterRepository = $characterRepository;
        $this->itemRepository = $itemRepository;
        $this->raceRepository = $raceRepository;
        $this->battleService = $battleService;
        $this->levelService = $levelService;
    }

    public function create(CreateCharacterCommand $command): Character
    {
        $race = $this->raceRepository->getOne($command->getRaceId());

        $character = $this->characterFactory->create($command, $race);

        $this->characterRepository->add($character);

        return $character;
    }

    public function getOne(string $characterId): Character
    {
        return $this->characterRepository->getOne($characterId);
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

    public function updateProfilePicture(Image $picture): void
    {
        $character = $this->characterRepository->getOne($picture->getCharacterId());

        $character->setProfilePictureId($picture->getId());

        $this->characterRepository->update($character);
    }

    public function removeProfilePicture(string $characterId): void
    {
        $character = $this->characterRepository->getOne($characterId);

        $character->removeProfilePicture();

        $this->characterRepository->update($character);
    }
}

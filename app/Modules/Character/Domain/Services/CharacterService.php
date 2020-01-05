<?php


namespace App\Modules\Character\Domain\Services;


use App\Modules\Battle\Domain\Entities\Battle;
use App\Modules\Character\Domain\Commands\AddItemToInventoryCommand;
use App\Modules\Character\Domain\Contracts\CharacterRepositoryInterface;
use App\Modules\Character\Domain\Contracts\LocationRepositoryInterface;
use App\Modules\Character\Domain\Entities\Location;
use App\Modules\Character\Domain\Factories\CharacterFactory;
use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Character\Domain\Commands\AttackCharacterCommand;
use App\Modules\Character\Domain\Commands\CreateCharacterCommand;
use App\Modules\Character\Domain\Commands\IncreaseAttributeCommand;
use App\Modules\Character\Domain\Commands\MoveCharacterCommand;
use App\Modules\Equipment\Domain\Commands\EquipItemCommand;
use App\Modules\Equipment\Domain\Contracts\ItemRepositoryInterface;
use App\Modules\Equipment\Domain\Entities\Item;
use App\Modules\Equipment\Domain\Services\ItemService;
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
     * @var LocationRepositoryInterface
     */
    private $locationRepository;
    /**
     * @var ItemRepositoryInterface
     */
    private $itemRepository;
    /**
     * @var BattleService
     */
    private $battleService;
    /**
     * @var LevelService
     */
    private $levelService;
    /**
     * @var ItemService
     */
    private $itemService;

    public function __construct(
        CharacterFactory $characterFactory,
        CharacterRepositoryInterface $characterRepository,
        LocationRepositoryInterface $locationRepository,
        ItemRepositoryInterface $itemRepository,
        BattleService $battleService,
        LevelService $levelService,
        ItemService $itemService
    )
    {
        $this->characterFactory = $characterFactory;
        $this->characterRepository = $characterRepository;
        $this->locationRepository = $locationRepository;
        $this->itemRepository = $itemRepository;
        $this->battleService = $battleService;
        $this->levelService = $levelService;
        $this->itemService = $itemService;
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

    public function equipItem(EquipItemCommand $command)
    {
        $item = $this->itemRepository->getOne($command->getItemId());
        $character = $this->characterRepository->getOne($command->getOwnerCharacterId());

        if ($character->getInventory()->hasItem($item) && !$item->isEquipped()) {
            $equippedItem = $character->getInventory()->findEquippedItemOfType($item->getType());

            if (!is_null($equippedItem)) {
                /** @var Item $equippedItem */
                $equippedItem->unEquip();
            }

            $item->equip();
        }
    }

    public function unEquipItem(EquipItemCommand $command)
    {
        $item = $this->itemRepository->getOne($command->getItemId());
        $character = $this->characterRepository->getOne($command->getOwnerCharacterId());

        if ($character->getInventory()->hasItem($item) && $item->isEquipped()) {
            /** @var Item $item */
            $item->unEquip();
        }
    }

    public function addItemToInventory(AddItemToInventoryCommand $command): Character
    {
        $character = $this->characterRepository->getOne($command->getCharacterId());
        $item = $this->itemRepository->getOne($command->getItemId());

        $character->addItemToInventorySlot($command->getSlot(), $item);

        return $character;
    }

    public function increaseAttribute(IncreaseAttributeCommand $command)
    {
        $character = $this->characterRepository->getOne($command->getCharacterId());

        $character->applyAttributeIncrease($command->getAttribute());
    }

    public function move(MoveCharacterCommand $command)
    {
        /** @var Character $character */
        $character = $this->characterRepository->getOne($command->getCharacterId());

        /** @var Location $location */
        $location = $this->locationRepository->getOne($command->getLocationId());

        $character->setLocation($location);
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

            return $battle;
        });
    }

    public function updateProfilePicture(Image $picture)
    {
        $character = $picture->getCharacter();

        $character->setProfilePicture($picture);
    }

    public function removeProfilePicture(string $characterId)
    {
        $character = $this->characterRepository->getOne($characterId);

        $character->removeProfilePicture();
    }
}

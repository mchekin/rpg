<?php

namespace Tests\Unit\App\Modules\Equipment\Domain\Services;

use App\Modules\Character\Domain\Contracts\CharacterRepositoryInterface;
use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Equipment\Domain\Commands\CreateItemCommand;
use App\Modules\Equipment\Domain\Contracts\ItemPrototypeRepositoryInterface;
use App\Modules\Equipment\Domain\Contracts\ItemRepositoryInterface;
use App\Modules\Equipment\Domain\Entities\ItemPrototype;
use App\Modules\Equipment\Domain\Factories\ItemFactory;
use App\Modules\Equipment\Domain\Services\ItemService;
use App\Modules\Equipment\Domain\ValueObjects\ItemEffect;
use App\Modules\Equipment\Domain\ValueObjects\ItemType;
use Illuminate\Support\Collection;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ItemServiceTest extends TestCase
{
    /** @var ItemService */
    private $sut;

    /** @var MockInterface| CharacterRepositoryInterface */
    private $characterRepository;

    /** @var MockInterface| ItemRepositoryInterface */
    private $itemRepository;

    /** @var MockInterface| ItemPrototypeRepositoryInterface */
    private $itemPrototypeRepository;

    /** @var MockInterface| Character */
    private $character;

    protected function setUp()
    {
        parent::setUp();

        $this->characterRepository = Mockery::mock(CharacterRepositoryInterface::class);
        $this->itemRepository = Mockery::mock(ItemRepositoryInterface::class);
        $this->itemPrototypeRepository = Mockery::mock(ItemPrototypeRepositoryInterface::class);
        $this->character = Mockery::mock(Character::class);

        $this->sut = new ItemService(
            $this->characterRepository,
            $this->itemRepository,
            $this->itemPrototypeRepository,
            new ItemFactory()
        );
    }

    public function testCreate()
    {
        // Arrange
        $prototypeId = '598d1570-e0e3-40d1-979b-64e48626f6f6';
        $name = 'Wooden club';
        $description = 'Club made from wood';
        $type = ItemType::mainHand();
        $effects = Collection::make([
            ItemEffect::damage(5)
        ]);
        $creatorCharacterId = '65976e46-d2eb-4373-ba69-b7c9ea81b56f';
        $imageFilePath = 'images\equipment\weapons\1club.png';

        $itemPrototype = new ItemPrototype(
            $prototypeId,
            $name,
            $description,
            $imageFilePath,
            $type,
            $effects
        );

        $createCommand = new CreateItemCommand($prototypeId, $creatorCharacterId);

        $this->characterRepository->shouldReceive('getOne')->once()->andReturn($this->character);
        $this->itemPrototypeRepository->shouldReceive('getOne')->once()->andReturn($itemPrototype);
        $this->character->shouldReceive('getId')->once()->andReturn($creatorCharacterId);
        $this->character->shouldReceive('addItemToInventory')->once();
        $this->itemRepository->shouldReceive('add')->once();
        $this->characterRepository->shouldReceive('update')->once();

        // Act
        $item = $this->sut->create($createCommand);

        // Assert
        $this->assertEquals($name, $item->getName());
        $this->assertEquals($description, $item->getDescription());
        $this->assertEquals($imageFilePath, $item->getImageFilePath());
        $this->assertEquals($type, $item->getType());
        $this->assertEquals($effects, $item->getEffects());
        $this->assertEquals($prototypeId, $item->getPrototypeId());
        $this->assertEquals($creatorCharacterId, $item->getCreatorCharacterId());
        $this->assertEquals($creatorCharacterId, $item->getOwnerCharacterId());
    }
}
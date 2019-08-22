<?php

namespace Tests\Unit\App\Modules\Equipment\Domain\Services;

use App\Modules\Character\Domain\Entities\Character;
use App\Modules\Equipment\Domain\Commands\CreateItemCommand;
use App\Modules\Equipment\Domain\Contracts\ItemPrototypeRepositoryInterface;
use App\Modules\Equipment\Domain\Contracts\ItemRepositoryInterface;
use App\Modules\Equipment\Domain\Entities\ItemPrototype;
use App\Modules\Equipment\Domain\Factories\ItemFactory;
use App\Modules\Equipment\Domain\Services\ItemService;
use App\Modules\Equipment\Domain\ValueObjects\ItemAttribute;
use App\Modules\Equipment\Domain\ValueObjects\ItemType;
use Illuminate\Support\Collection;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ItemServiceTest extends TestCase
{
    /** @var ItemService */
    private $sut;

    /** @var MockInterface| ItemRepositoryInterface */
    private $itemRepository;

    /** @var MockInterface| ItemPrototypeRepositoryInterface */
    private $itemPrototypeRepository;

    /** @var MockInterface| Character */
    private $character;

    protected function setUp()
    {
        parent::setUp();

        $this->itemRepository = Mockery::mock(ItemRepositoryInterface::class);
        $this->itemPrototypeRepository = Mockery::mock(ItemPrototypeRepositoryInterface::class);
        $this->character = Mockery::mock(Character::class);

        $this->sut = new ItemService($this->itemRepository, $this->itemPrototypeRepository, new ItemFactory());
    }

    public function testCreate()
    {
        // Arrange
        $title = 'Wooden club';
        $description = 'Club made from wood';
        $type = ItemType::mainHand();
        $effects = Collection::make([
            ItemAttribute::damage(5)
        ]);
        $creatorCharacterId = '65976e46-d2eb-4373-ba69-b7c9ea81b56f';

        $itemPrototype = new ItemPrototype(
            $title,
            $description,
            $type,
            $effects
        );

        $createCommand = new CreateItemCommand($title, $creatorCharacterId);

        $this->itemPrototypeRepository->shouldReceive('getOne')->once()->andReturn($itemPrototype);
        $this->itemRepository->shouldReceive('add')->once();

        // Act
        $item = $this->sut->create($createCommand);

        // Assert
        $this->assertEquals($title, $item->getTitle());
        $this->assertEquals($description, $item->getDescription());
        $this->assertEquals($type, $item->getType());
        $this->assertEquals($effects, $item->getEffects());
        $this->assertEquals($creatorCharacterId, $item->getCreatorCharacterId());
    }
}
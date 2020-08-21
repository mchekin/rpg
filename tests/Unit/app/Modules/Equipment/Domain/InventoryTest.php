<?php declare(strict_types=1);


namespace Tests\Unit\app\Modules\Equipment\Domain;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\Inventory;
use App\Modules\Equipment\Domain\InventoryId;
use App\Modules\Equipment\Domain\Item;
use App\Modules\Equipment\Domain\Money;
use App\Modules\Generic\Domain\Container\NotEnoughSpaceInContainerException;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    /** @var InventoryId */
    private $id;

    /** @var CharacterId */
    private $characterId;

    /** @var Money */
    private $money;

    protected function setUp(): void
    {
        parent::setUp();

        $this->id = Mockery::mock(InventoryId::class);
        $this->characterId = Mockery::mock(CharacterId::class);
        $this->money = Mockery::mock(Money::class);
    }

    public function testWillThrowExceptionOnTryingToCreateInventoryWithTooManySlots(): void
    {
        $items = Collection::make(array_map(static function () {

           return Mockery::mock(Item::class);

        }, range(0, Inventory::NUMBER_OF_SLOTS)));

        $this->expectException(NotEnoughSpaceInContainerException::class);

        new Inventory(
            $this->id,
            $this->characterId,
            $items,
            $this->money
        );
    }
}

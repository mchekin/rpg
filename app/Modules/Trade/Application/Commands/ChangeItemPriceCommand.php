<?php declare(strict_types=1);

namespace App\Modules\Trade\Application\Commands;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\ItemId;
use App\Modules\Equipment\Domain\ItemPrice;
use App\Modules\Generic\Domain\ContainerType;

class ChangeItemPriceCommand
{
    /**
     * @var ItemId
     */
    private $itemId;
    /**
     * @var ItemPrice
     */
    private $itemPrice;
    /**
     * @var CharacterId
     */
    private $characterId;
    /**
     * @var ContainerType
     */
    private $containerType;

    public function __construct(
        ItemId $itemId,
        ItemPrice $itemPrice,
        CharacterId $characterId,
        ContainerType $containerType
    ) {
        $this->itemId = $itemId;
        $this->itemPrice = $itemPrice;
        $this->characterId = $characterId;
        $this->containerType = $containerType;
    }

    public function getItemId(): ItemId
    {
        return $this->itemId;
    }

    public function getItemPrice(): ItemPrice
    {
        return $this->itemPrice;
    }

    public function getCharacterId(): CharacterId
    {
        return $this->characterId;
    }

    public function getContainerType(): ContainerType
    {
        return $this->containerType;
    }
}

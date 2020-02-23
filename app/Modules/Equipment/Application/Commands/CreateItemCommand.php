<?php

namespace App\Modules\Equipment\Application\Commands;

use App\Modules\Character\Domain\CharacterId;
use App\Modules\Equipment\Domain\ItemPrototypeId;

class CreateItemCommand
{
    /**
     * @var ItemPrototypeId
     */
    private $prototypeId;
    /**
     * @var CharacterId
     */
    private $creatorCharacterId;

    public function __construct(ItemPrototypeId $prototypeId, CharacterId $creatorCharacterId)
    {
        $this->prototypeId = $prototypeId;
        $this->creatorCharacterId = $creatorCharacterId;
    }

    public function getPrototypeId(): ItemPrototypeId
    {
        return $this->prototypeId;
    }

    public function getCreatorCharacterId(): CharacterId
    {
        return $this->creatorCharacterId;
    }
}

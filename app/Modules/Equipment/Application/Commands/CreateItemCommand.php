<?php

namespace App\Modules\Equipment\Application\Commands;

use App\Modules\Character\Domain\CharacterId;

class CreateItemCommand
{
    /**
     * @var string
     */
    private $prototypeId;
    /**
     * @var CharacterId
     */
    private $creatorCharacterId;

    public function __construct(string $prototypeId, CharacterId $creatorCharacterId)
    {
        $this->prototypeId = $prototypeId;
        $this->creatorCharacterId = $creatorCharacterId;
    }

    public function getPrototypeId(): string
    {
        return $this->prototypeId;
    }

    public function getCreatorCharacterId(): CharacterId
    {
        return $this->creatorCharacterId;
    }
}

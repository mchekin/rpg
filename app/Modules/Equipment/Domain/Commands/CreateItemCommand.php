<?php

namespace App\Modules\Equipment\Domain\Commands;

class CreateItemCommand
{
    /**
     * @var string
     */
    private $prototypeId;
    /**
     * @var string
     */
    private $creatorCharacterId;

    public function __construct(string $prototypeId, string $creatorCharacterId)
    {
        $this->prototypeId = $prototypeId;
        $this->creatorCharacterId = $creatorCharacterId;
    }

    /**
     * @return string
     */
    public function getPrototypeId(): string
    {
        return $this->prototypeId;
    }

    /**
     * @return string
     */
    public function getCreatorCharacterId(): string
    {
        return $this->creatorCharacterId;
    }
}
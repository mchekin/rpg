<?php


namespace App\Modules\Message\Domain\Factories;


use App\Modules\Message\Domain\Entities\Message;
use App\Modules\Message\Domain\Commands\SendMessageCommand;
use App\Traits\GeneratesUuid;

class MessageFactory
{
    use GeneratesUuid;

    public function create(SendMessageCommand $command): Message
    {
        return new Message(
            $this->generateUuid(),
            $command->getSenderId(),
            $command->getRecipientId(),
            $command->getContent()
        );
    }
}
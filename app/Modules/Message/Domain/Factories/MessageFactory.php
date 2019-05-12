<?php


namespace App\Modules\Message\Domain\Factories;


use App\Modules\Message\Domain\Entities\Message;
use App\Modules\Message\Domain\Requests\SendMessageRequest;
use App\Traits\GeneratesUuid;

class MessageFactory
{
    use GeneratesUuid;

    public function create(SendMessageRequest $request): Message
    {
        return new Message(
            $this->generateUuid(),
            $request->getSenderId(),
            $request->getRecipientId(),
            $request->getContent()
        );
    }
}
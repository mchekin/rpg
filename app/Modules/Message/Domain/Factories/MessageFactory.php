<?php


namespace App\Modules\Message\Domain\Factories;


use App\Modules\Message\Domain\Entities\Message;
use App\Modules\Message\Domain\Requests\SendMessageRequest;

class MessageFactory
{
    public function create(SendMessageRequest $request): Message
    {
        return new Message(
            $request->getSenderId(),
            $request->getRecipientId(),
            $request->getContent()
        );
    }
}
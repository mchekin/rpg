<?php

namespace App\Modules\Message\Infrastructure\Repositories;

use App\Modules\Message\Domain\MessageId;
use App\Modules\Message\Domain\Message;
use App\Message as MessageModel;
use App\Modules\Message\Application\Contracts\MessageRepositoryInterface;
use App\Traits\GeneratesUuid;
use Exception;

class MessageRepository implements MessageRepositoryInterface
{
    use GeneratesUuid;

    /**
     * @return MessageId
     *
     * @throws Exception
     */
    public function nextIdentity(): MessageId
    {
        return MessageId::fromString($this->generateUuid());
    }

    public function add(Message $message): void
    {
        MessageModel::query()->create([
            'id' => $message->getId()->toString(),
            'from_id' => $message->getSenderId()->toString(),
            'to_id' => $message->getRecipientId()->toString(),
            'content' => $message->getContent(),
            'state' => $message->getState()
        ]);
    }
}

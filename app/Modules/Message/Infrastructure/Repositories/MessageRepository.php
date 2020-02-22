<?php

namespace App\Modules\Message\Infrastructure\Repositories;

use App\Modules\Message\Domain\Message;
use App\Message as MessageModel;
use App\Modules\Message\Infrastructure\ReconstitutionFactories\MessageReconstitutionFactory;
use App\Modules\Message\Application\Contracts\MessageRepositoryInterface;

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * @var MessageReconstitutionFactory
     */
    private $characterReconstitutionFactory;

    public function __construct(MessageReconstitutionFactory $characterReconstitutionFactory)
    {
        $this->characterReconstitutionFactory = $characterReconstitutionFactory;
    }

    public function add(Message $message): void
    {
        MessageModel::query()->create([
            'id' => $message->getId(),
            'from_id' => $message->getSenderId(),
            'to_id' => $message->getRecipientId(),
            'content' => $message->getContent(),
            'state' => $message->getState()
        ]);
    }

    public function getOne(string $messageId): Message
    {
        /** @var MessageModel $characterModel */
        $characterModel = MessageModel::query()->findOrFail($messageId);

        return $this->characterReconstitutionFactory->reconstitute($characterModel);
    }
}

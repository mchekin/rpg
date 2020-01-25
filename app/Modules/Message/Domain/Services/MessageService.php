<?php

namespace App\Modules\Message\Domain\Services;

use App\Modules\Character\Domain\Contracts\CharacterRepositoryInterface;
use App\Modules\Message\Domain\Contracts\MessageRepositoryInterface;
use App\Modules\Message\Domain\Entities\Message;
use App\Modules\Message\Domain\Commands\SendMessageCommand;
use App\Traits\GeneratesUuid;

class MessageService
{
    use GeneratesUuid;

    /**
     * @var MessageRepositoryInterface
     */
    private $messageRepository;
    /**
     * @var CharacterRepositoryInterface
     */
    private $characterRepository;

    public function __construct(
        MessageRepositoryInterface $messageRepository,
        CharacterRepositoryInterface $characterRepository
    )
    {
        $this->messageRepository = $messageRepository;
        $this->characterRepository = $characterRepository;
    }

    public function send(SendMessageCommand $command)
    {
        $sender = $this->characterRepository->getOne($command->getSenderId());
        $recipient = $this->characterRepository->getOne($command->getRecipientId());

        $message = new Message(
            $this->generateUuid(),
            $sender,
            $recipient,
            $command->getContent()
        );

        $this->messageRepository->add($message);
    }
}

<?php


namespace App\Modules\Message\Application\Services;


use App\Modules\Message\Application\Contracts\MessageRepositoryInterface;
use App\Modules\Message\Application\Commands\SendMessageCommand;
use App\Modules\Message\Domain\Message;

class MessageService
{
    /**
     * @var MessageRepositoryInterface
     */
    private $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function send(SendMessageCommand $command): void
    {
        $message = new Message(
            $this->messageRepository->nextIdentity(),
            $command->getSenderId(),
            $command->getRecipientId(),
            $command->getContent()
        );

        $this->messageRepository->add($message);
    }
}

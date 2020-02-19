<?php


namespace App\Modules\Message\Application\Services;


use App\Modules\Message\Application\Contracts\MessageRepositoryInterface;
use App\Modules\Message\Application\Factories\MessageFactory;
use App\Modules\Message\Application\Commands\SendMessageCommand;

class MessageService
{
    /**
     * @var MessageFactory
     */
    private $factory;
    /**
     * @var MessageRepositoryInterface
     */
    private $messageRepository;

    public function __construct(MessageFactory $factory, MessageRepositoryInterface $messageRepository)
    {
        $this->factory = $factory;
        $this->messageRepository = $messageRepository;
    }

    public function send(SendMessageCommand $command): void
    {
        $message = $this->factory->create($command);

        $this->messageRepository->add($message);
    }
}

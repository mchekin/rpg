<?php


namespace App\Modules\Message\Domain\Services;


use App\Modules\Message\Domain\Contracts\MessageRepositoryInterface;
use App\Modules\Message\Domain\Factories\MessageFactory;
use App\Modules\Message\Domain\Commands\SendMessageCommand;

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

    public function send(SendMessageCommand $command)
    {
        $message = $this->factory->create($command);

        $this->messageRepository->add($message);
    }
}
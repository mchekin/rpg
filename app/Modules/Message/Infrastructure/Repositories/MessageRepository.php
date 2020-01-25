<?php

namespace App\Modules\Message\Infrastructure\Repositories;

use App\Modules\Message\Domain\Entities\Message;
use App\Modules\Message\Domain\Contracts\MessageRepositoryInterface;
use Doctrine\ORM\EntityManager;

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Message $message
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function add(Message $message): void
    {
        $this->entityManager->persist($message);
    }

    /**
     * @param string $messageId
     *
     * @return Message
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function getOne(string $messageId): Message
    {
        /** @var Message $message */
        $message = $this->entityManager->find(Message::class, $messageId);

        return $message;
    }
}

<?php


namespace App\Modules\Message\Domain\Entities;

class Message
{
    const UNREAD = 'unread';
    const READ = 'read';

    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $senderId;
    /**
     * @var string
     */
    private $recipientId;
    /**
     * @var string
     */
    private $content;
    /**
     * @var string
     */
    private $state;

    public function __construct(
        string $id,
        string $senderId,
        string $recipientId,
        string $content,
        string $state = self::UNREAD
    ) {
        $this->id = $id;
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->content = $content;
        $this->state = $state;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSenderId(): string
    {
        return $this->senderId;
    }

    public function getRecipientId(): string
    {
        return $this->recipientId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getState(): string
    {
        return $this->state;
    }
}

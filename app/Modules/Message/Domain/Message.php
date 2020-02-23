<?php


namespace App\Modules\Message\Domain;

use App\Modules\Character\Domain\CharacterId;

class Message
{
    public const UNREAD = 'unread';
    public const READ = 'read';

    /**
     * @var MessageId
     */
    private $id;
    /**
     * @var CharacterId
     */
    private $senderId;
    /**
     * @var CharacterId
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
        MessageId $id,
        CharacterId $senderId,
        CharacterId $recipientId,
        string $content,
        string $state = self::UNREAD
    ) {
        $this->id = $id;
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->content = $content;
        $this->state = $state;
    }

    public function getId(): MessageId
    {
        return $this->id;
    }

    public function getSenderId(): CharacterId
    {
        return $this->senderId;
    }

    public function getRecipientId(): CharacterId
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

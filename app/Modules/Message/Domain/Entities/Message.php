<?php


namespace App\Modules\Message\Domain\Entities;


use App\Traits\ContainsModel;

class Message
{
    // Todo: temporary hack of having reference to the Eloquent model
    use ContainsModel;

    const DEFAULT_STATE = 0;

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
     * @var int
     */
    private $state;

    public function __construct(
        string $id,
        string $senderId,
        string $recipientId,
        string $content,
        int $state = self::DEFAULT_STATE
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

    public function getState(): int
    {
        return $this->state;
    }
}
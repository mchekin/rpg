<?php


namespace App\Modules\Message\Domain\Requests;


class SendMessageRequest
{
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

    public function __construct(string $senderId, string $recipientId, string $content)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->content = $content;
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
}
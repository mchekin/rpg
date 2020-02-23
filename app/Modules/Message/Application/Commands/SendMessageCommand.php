<?php


namespace App\Modules\Message\Application\Commands;


use App\Modules\Character\Domain\CharacterId;

class SendMessageCommand
{
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

    public function __construct(CharacterId $senderId, CharacterId $recipientId, string $content)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->content = $content;
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
}

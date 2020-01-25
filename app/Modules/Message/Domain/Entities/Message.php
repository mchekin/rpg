<?php


namespace App\Modules\Message\Domain\Entities;


use App\Modules\Character\Domain\Entities\Character;
use Carbon\Carbon;

class Message
{
    const UNREAD = 'unread';
    const READ = 'read';

    /**
     * @var string
     */
    private $id;
    /**
     * @var Character
     */
    private $sender;
    /**
     * @var Character
     */
    private $recipient;
    /**
     * @var string
     */
    private $content;
    /**
     * @var string
     */
    private $state;
    /**
     * @var Carbon
     */
    private $createdAt;
    /**
     * @var Carbon
     */
    private $updatedAt;
    /**
     * @var Carbon
     */
    private $deletedAt;

    public function __construct(
        string $id,
        Character $sender,
        Character $recipient,
        string $content,
        string $state = self::UNREAD
    )
    {
        $this->id = $id;
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->content = $content;
        $this->state = $state;

        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();
        $this->deletedAt = Carbon::now();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSender(): Character
    {
        return $this->sender;
    }

    public function getRecipient(): Character
    {
        return $this->recipient;
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

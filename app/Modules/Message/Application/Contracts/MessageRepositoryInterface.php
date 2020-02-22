<?php


namespace App\Modules\Message\Application\Contracts;

use App\Modules\Message\Domain\Message;

interface MessageRepositoryInterface
{
    public function add(Message $message):void;

    public function getOne(string $messageId): Message;
}

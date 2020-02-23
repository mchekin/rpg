<?php


namespace App\Modules\Message\Application\Contracts;

use App\Modules\Message\Domain\MessageId;
use App\Modules\Message\Domain\Message;

interface MessageRepositoryInterface
{
    public function nextIdentity(): MessageId;

    public function add(Message $message):void;
}

<?php


namespace App\Modules\Message\Infrastructure\ReconstitutionFactories;

use App\Modules\Message\Domain\Entities\Message;
use App\Message as MessageModel;


class MessageReconstitutionFactory
{
    public function reconstitute(MessageModel $characterModel): Message
    {
        $character = new Message(
            $characterModel->id,
            $characterModel->from_id,
            $characterModel->to_id,
            $characterModel->content,
            $characterModel->state
        );

        return $character;
    }
}

<?php

namespace App\Contracts\Models;

interface MessageInterface
{
    public function unseenByRecipient(): bool;
}
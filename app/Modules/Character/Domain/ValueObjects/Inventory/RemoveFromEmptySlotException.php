<?php

namespace App\Modules\Character\Domain\ValueObjects\Inventory;

use InvalidArgumentException;

class RemoveFromEmptySlotException extends InvalidArgumentException
{
}
<?php

namespace App\Modules\Character\Domain\ValueObjects\Inventory;

use InvalidArgumentException;

class InventoryIsFullException extends InvalidArgumentException
{
}
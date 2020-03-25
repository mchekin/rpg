<?php declare(strict_types=1);


namespace App\Modules\Equipment\Domain\Inventory;

use InvalidArgumentException;

class ItemNotInInventory extends InvalidArgumentException
{
}

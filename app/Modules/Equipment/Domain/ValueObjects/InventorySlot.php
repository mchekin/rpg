<?php declare(strict_types=1);


namespace App\Modules\Equipment\Domain\ValueObjects;


class InventorySlot
{
    private $slot;

    public static function undefined(): self
    {
        return new self(-1);
    }

    public static function defined(int $slot)
    {
        return new self($slot);
    }

    public function __construct(int $slot)
    {
        $this->slot = $slot;
    }

    public function getSlot(): int
    {
        return $this->slot;
    }
}
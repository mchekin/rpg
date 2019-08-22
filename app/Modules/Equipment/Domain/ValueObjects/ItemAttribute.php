<?php

namespace App\Modules\Equipment\Domain\ValueObjects;


class ItemAttribute
{
    const DAMAGE = 'damage';
    const ARMOR = 'armor';

    /**
     * @var int
     */
    private $quantity;
    /**
     * @var string
     */
    private $type;

    private function __construct(int $quantity, string $type)
    {
        $this->quantity = $quantity;
        $this->type = $type;
    }

    public static function damage(int $quantity)
    {
        return new self($quantity, self::DAMAGE);
    }

    public static function armor(int $quantity)
    {
        return new self($quantity, self::ARMOR);
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
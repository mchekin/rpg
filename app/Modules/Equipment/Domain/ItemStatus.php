<?php

namespace App\Modules\Equipment\Domain;

use InvalidArgumentException;

class ItemStatus
{
    public const EQUIPPED = 'equipped';
    public const IN_BACKPACK = 'in_backpack';
    public const FOR_SALE = 'for_sale';

    public const STATUSES = [
        self::EQUIPPED,
        self::IN_BACKPACK,
        self::FOR_SALE,
    ];

    /**
     * @var string
     */
    private $type;

    private function __construct(string $type)
    {
        $this->type = $type;
    }

    public static function ofStatus(string $status): self
    {
        if (!in_array($status, self::STATUSES, true)) {
            throw new InvalidArgumentException("$status is not a valid Item Status");
        }

        return new self($status);
    }

    public static function inBackpack(): self
    {
        return new self(self::IN_BACKPACK);
    }

    public static function forSale(): self
    {
        return new self(self::FOR_SALE);
    }

    public static function equipped(): self
    {
        return new self(self::EQUIPPED);
    }

    public function toString(): string
    {
        return $this->type;
    }

    public function equals(self $type): bool
    {
        return $this->type === $type->toString();
    }
}

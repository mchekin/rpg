<?php

namespace App\Modules\Trade\Domain;

use InvalidArgumentException;

class StoreType
{
    public const SELL_ONLY = 'sell_only';
    public const BUY_AND_SELL = 'by_and_sell';

    public const TYPES = [
        self::SELL_ONLY,
        self::BUY_AND_SELL,
    ];

    /**
     * @var string
     */
    private $type;

    private function __construct(string $type)
    {
        $this->type = $type;
    }

    public static function ofType(string $type): self
    {
        if (!in_array($type, self::TYPES, true)) {
            throw new InvalidArgumentException("$type is not a valid Item Type");
        }

        return new self($type);
    }

    public static function buyAndSell(): self
    {
        return new self(self::BUY_AND_SELL);
    }

    public static function sellOnly(): self
    {
        return new self(self::SELL_ONLY);
    }

    public function toString(): string
    {
        return $this->type;
    }

    public function isSellOnly(): bool
    {
        return $this->type === self::SELL_ONLY;
    }
}

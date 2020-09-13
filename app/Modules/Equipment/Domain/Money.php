<?php declare(strict_types=1);


namespace App\Modules\Equipment\Domain;


use App\Modules\Generic\Domain\Container\InvalidMoneyValue;
use App\Modules\Generic\Domain\Container\NotEnoughMoneyToRemove;

class Money
{
    /**
     * @var int
     */
    private $value;

    public function __construct(int $value)
    {
        if ($value < 0)
        {
           throw new InvalidMoneyValue('Negative money amount not allowed');
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function remove(Money $money): self
    {
        if ($this->value < $money->getValue()) {
            throw new NotEnoughMoneyToRemove('Cannot remove more money than there is');
        }

        return new self($this->value - $money->getValue());
    }

    public function combine(Money $money): self
    {
        return new self($this->value + $money->getValue());
    }
}

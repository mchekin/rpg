<?php


namespace App\Modules\Character\Domain\Entities;


class Location
{
    /**
 * @var int
 */
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
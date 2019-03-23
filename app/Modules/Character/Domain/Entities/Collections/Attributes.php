<?php


namespace App\Modules\Character\Domain\Entities;


use Illuminate\Support\Collection;

class Attributes extends Collection
{
    public function __construct($items = [])
    {
        parent::__construct($items);
    }
}
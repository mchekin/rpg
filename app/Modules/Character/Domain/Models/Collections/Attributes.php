<?php


namespace App\Modules\Character\Domain\Models;


use Illuminate\Support\Collection;

class Attributes extends Collection
{
    public function __construct($items = [])
    {
        parent::__construct($items);
    }
}
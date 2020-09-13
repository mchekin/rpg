<?php declare(strict_types=1);


namespace App\Modules\Generic\Domain;


use Illuminate\Support\Collection;

abstract class Container
{

    /**
     * @var Collection
     */
    protected $items;
}

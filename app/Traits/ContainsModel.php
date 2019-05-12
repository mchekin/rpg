<?php


namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait ContainsModel
{
    /**
     * @var Model
     */
    private $model;

    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    public function getModel(): Model
    {
        return $this->model;
    }
}
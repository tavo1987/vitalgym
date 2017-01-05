<?php

namespace App\VitalGym\Repositories;

abstract class BaseRepository
{
    protected $model;

    /**
     * BaseRepo constructor.
     */
    public function __construct()
    {
        $this->model = $this->getModel();
    }

    /**
     * @return mixed
     */
    abstract public function getModel();
}

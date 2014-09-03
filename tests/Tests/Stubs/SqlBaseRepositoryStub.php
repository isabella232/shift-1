<?php namespace Tests\Stubs;

use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;

class SqlBaseRepositoryStub extends Repository
{
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }
}
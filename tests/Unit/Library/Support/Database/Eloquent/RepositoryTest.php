<?php

namespace Tests\Unit\Library\Support\Database\Eloquent;

use Mockery as m;
use Tests\Stubs\EloquentRepositoryStub;

class RepositoryTest
{
    public function setUp()
    {
        parent::setUp();

        $this->model = m::spy('someModel');
        $this->repository = new EloquentRepositoryStub($this->model);
    }

    public function testNewInstanceCreation()
    {
        $this->repository->getNew();

        $this->model->shouldHaveReceived('newInstance')->once();
    }
}

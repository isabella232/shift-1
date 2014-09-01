<?php namespace Tests\Stubs;

use Tectonic\Shift\Library\Support\ManagementService;

class ManagementServiceStub extends ManagementService
{
    public function __construct($repository, $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}

<?php namespace Tests\Stubs;

use Tectonic\Shift\Library\Support\BaseManagementService;

class BaseManagementServiceStub extends BaseManagementService
{
    public function __construct($repository, $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}

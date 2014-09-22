<?php namespace Tests\Stubs;

use Tectonic\Shift\Library\Support\ManagementService;

class ManagementServiceStub extends ManagementService
{
    public function __construct($repository, $createValidator, $updateValidator)
    {
        $this->repository = $repository;
        $this->createValidator = $createValidator;
        $this->updateValidator = $updateValidator;
    }
}

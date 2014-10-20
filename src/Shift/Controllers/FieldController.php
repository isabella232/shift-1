<?php namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Fields\Validators\FieldValidator;
use Tectonic\Shift\Modules\Fields\Services\FieldManagementService;
use Tectonic\Shift\Modules\Fields\Repositories\FieldRepositoryInterface;

class FieldController extends Controller
{

    public function __construct(
        FieldRepositoryInterface $repository,
        FieldValidator $validator,
        FieldManagementService $service
    ) {
        $this->validator   = $validator;
        $this->repository  = $repository;
        $this->crudService = $service;
    }

}

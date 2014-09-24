<?php namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\CustomFields\Validators\CustomFieldValidator;
use Tectonic\Shift\Modules\CustomFields\Services\CustomFieldManagementService;
use Tectonic\Shift\Modules\CustomFields\Repositories\FieldRepositoryInterface;

class FieldController extends Controller
{

    public function __construct(
        FieldRepositoryInterface $repository,
        CustomFieldValidator $validator,
        CustomFieldManagementService $service
    ) {
        $this->validator   = $validator;
        $this->repository  = $repository;
        $this->crudService = $service;
    }

}

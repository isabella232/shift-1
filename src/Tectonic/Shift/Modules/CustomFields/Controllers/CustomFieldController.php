<?php namespace Tectonic\Shift\Modules\CustomFields\Controllers;

use Tectonic\Shift\Library\Support\BaseController;
use Tectonic\Shift\Modules\CustomFields\Validators\CustomFieldValidator;
use Tectonic\Shift\Modules\CustomFields\Services\CustomFieldManagementService;
use Tectonic\Shift\Modules\CustomFields\Repositories\CustomFieldRepositoryInterface;

class CustomFieldController extends BaseController
{

    public function __construct(
        CustomFieldRepositoryInterface $repository,
        CustomFieldValidator $validator,
        CustomFieldManagementService $crudService
    ) {
        $this->validator   = $validator;
        $this->repository  = $repository;
        $this->crudService = $crudService;
    }

}

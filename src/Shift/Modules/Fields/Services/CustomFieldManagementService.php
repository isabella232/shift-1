<?php namespace Tectonic\Shift\Modules\CustomFields\Services;

use Tectonic\Shift\Library\Support\ManagementService;
use Tectonic\Shift\Modules\CustomFields\Validators\CustomFieldValidator;
use Tectonic\Shift\Modules\CustomFields\Repositories\FieldRepositoryInterface;

class CustomFieldManagementService extends ManagementService
{
    /**
     * @param FieldRepositoryInterface $repository
     * @param CustomFieldValidator           $validator
     */
    public function __construct(FieldRepositoryInterface $repository, CustomFieldValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}

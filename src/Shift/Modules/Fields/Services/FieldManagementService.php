<?php namespace Tectonic\Shift\Modules\Fields\Services;

use Tectonic\Shift\Library\Support\ManagementService;
use Tectonic\Shift\Modules\Fields\Validators\FieldValidator;
use Tectonic\Shift\Modules\Fields\Repositories\FieldRepositoryInterface;

class FieldManagementService extends ManagementService
{
    /**
     * @param FieldRepositoryInterface $repository
     * @param FieldValidator           $validator
     */
    public function __construct(FieldRepositoryInterface $repository, FieldValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}

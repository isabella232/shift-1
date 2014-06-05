<?php namespace Tectonic\Shift\Modules\CustomFields\Services;

use Tectonic\Shift\Library\Support\BaseManagementService;
use Tectonic\Shift\Modules\CustomFields\Validators\CustomFieldValidator;
use Tectonic\Shift\Modules\CustomFields\Repositories\CustomFieldRepositoryInterface;

class CustomFieldManagementService extends BaseManagementService
{
    protected $repository;

    protected $validator;

    public function __construct(CustomFieldRepositoryInterface $repository, CustomFieldValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create($data)
    {
        $this->validator
            ->setInput($data)
            ->forMethod('create')
            ->validate();

        $resource = $this->repository->getNew($data);

        return $this->repository->save($resource);
    }

    public function get($id)
    {
        return $this->repository->requiredById($id);
    }

}

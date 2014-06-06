<?php namespace Tectonic\Shift\Modules\Security\Services;

use Tectonic\Shift\Library\Support\BaseManagementService;
use Tectonic\Shift\Modules\Security\Validators\RoleValidator;
use Tectonic\Shift\Modules\Security\Repositories\RoleRepository;

class RoleManagementService extends BaseManagementService
{
    /**
     * @param RoleRepository $repository
     * @param RoleValidator $validator
     */
    public function __construct(RoleRepository $repository, RoleValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}

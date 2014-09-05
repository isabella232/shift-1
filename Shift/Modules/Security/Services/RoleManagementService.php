<?php namespace Tectonic\Shift\Modules\Security\Services;

use Tectonic\Shift\Library\Support\ManagementService;
use Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Security\Validators\RoleValidator;

class RoleManagementService extends ManagementService
{
    /**
     * @param RoleRepositoryInterface $roleRepository
     * @param RoleValidator $roleValidator
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->repository = $roleRepository;
    }


}

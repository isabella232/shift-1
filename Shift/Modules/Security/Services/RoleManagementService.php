<?php namespace Tectonic\Shift\Modules\Security\Services;

use Tectonic\Shift\Library\Support\ManagementService;
use Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface;

class RoleManagementService extends ManagementService
{
    /**
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->repository = $roleRepository;
    }
}

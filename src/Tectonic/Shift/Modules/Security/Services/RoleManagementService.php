<?php namespace Tectonic\Shift\Modules\Security\Services;

use Tectonic\Shift\Modules\Security\Repositories\RoleRepository;

class RoleManagementService
{
    /**
     * Stores the role repository for saving successful role management requests.
     *
     * @var RoleRepository
     */
    public $roleRepository;

    /**
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Sets the default role for new user accounts.
     *
     * @param $role
     */
    public function setDefault($role)
    {
        $defaultRole = $this->roleRepository->getByDefault();

        if (!isset($role->id) or $defaultRole->id != $role->id) {
            $this->roleRepository->setDefaultRole($role);
        }
    }
} 
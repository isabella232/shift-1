<?php namespace Tectonic\Shift\Modules\Security\Services;

use Tectonic\Shift\Modules\Security\Repositories\RoleRepository;
use Tectonic\Shift\Modules\Security\Validators\RoleValidator;


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
     * @param RoleValidator $roleValidator
     */
    public function __construct(RoleRepository $roleRepository, RoleValidator $roleValidator)
    {
        $this->roleRepository = $roleRepository;
        $this->roleValidator = $roleValidator;
    }

    public function createRole($input)
    {
        $this->roleValidator->validate($input)->forMethod('create');


    }
} 
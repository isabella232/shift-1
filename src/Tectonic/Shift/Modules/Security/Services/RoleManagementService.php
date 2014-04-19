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
     * @param array $input
     */
    public function create($input)
    {
        $this->validator->setInput($input)
            ->forMethod('create')
            ->validate();

        $resource = $this->repository->create($input);

        $this->repository->save($resource);

        if (!empty($input['default'])) {
            $this->repository->setDefault($resource);
        }

        return $resource;
    }
} 
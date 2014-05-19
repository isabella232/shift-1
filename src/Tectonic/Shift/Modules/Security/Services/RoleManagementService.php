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

    /**
     * Sets the default role for new user accounts.
     *
     * @param array $input
     */
    public function create($input)
    {
        $this->roleValidator->setInput($input)
            ->forMethod('create')
            ->validate();

        $resource = $this->roleRepository->getNew($input);

        return $this->roleRepository->save($resource);
    }

    /**
     * Retrieves a single role object and returns the result.
     *
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->roleRepository->requireById($id);
    }

    /**
     * Update a specific role, based on the id provided.
     *
     * @param $id
     * @param $input
     * @return mixed
     */
    public function update($id, $input)
    {
        $resource = $this->roleRepository->requireById($id);

        $this->roleValidator->setInput($input)
            ->forMethod('update')
            ->using($resource)
            ->validate();

        return $this->roleRepository->update($resource, $input);
    }

    /**
     * Delete a role based on the id provided.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $resource = $this->roleRepository->requireById($id);

        return $this->roleRepository->delete($resource);
    }
} 
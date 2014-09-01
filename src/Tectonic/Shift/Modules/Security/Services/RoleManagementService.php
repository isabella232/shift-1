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
    public function __construct(RoleRepositoryInterface $roleRepository, RoleValidator $roleValidator)
    {
        $this->repository = $roleRepository;
        $this->validator = $roleValidator;
    }

    /**
     * Sets the default role for new user accounts.
     *
     * @param array $input
     * @return resource
     */
    public function create($input)
    {
        $this->validator->setInput($input)
            ->forMethod('create')
            ->validate();

        $resource = $this->repository->getNew($input);

        return $this->repository->save($resource);
    }

    /**
     * Retrieves a single role object and returns the result.
     *
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->repository->requireById($id);
    }
}

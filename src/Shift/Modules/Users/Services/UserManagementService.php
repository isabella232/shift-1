<?php

namespace Tectonic\Shift\Modules\Users\Services;

use Tectonic\Shift\Library\Support\ManagementService;
use Tectonic\Shift\Modules\Users\Repositories\UserRepositoryInterface;
use Tectonic\Shift\Modules\Users\Validation\UserValidation;

/**
 * Class UserManagementService
 *
 * Class to manage the normal crud operations for users.
 *
 * @package Tectonic\Shift\Modules\Users\Services
 */
class UserManagementService extends ManagementService
{
    public function __construct(UserRepositoryInterface $repository, UserValidation $validator)
    {
        $this->repository = $repository;
        $this->createValidator = $validator;
        $this->updateValidator = $validator;
    }
}

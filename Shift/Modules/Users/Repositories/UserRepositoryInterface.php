<?php

namespace Tectonic\Shift\Modules\Users\Repositories;

use Tectonic\Shift\Library\Support\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Should return a user object based on the email address.
     *
     * @param $email
     * @return mixed
     */
    public function getByEmail($email);
}

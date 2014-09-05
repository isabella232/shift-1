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

    /**
     * Find a user's record based on their email address, and an accountId.
     *
     * @param string $email
     * @param integer $accountId
     * @return object
     */
    public function getByEmailAndAccount($email, $accountId);
}

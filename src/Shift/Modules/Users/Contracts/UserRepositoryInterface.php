<?php
namespace Tectonic\Shift\Modules\Users\Contracts;

use Tectonic\Shift\Library\Support\Database\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Should return a user object based on the email address.
     *
     * @param string $email
     * @return object|null
     */
    public function getByEmail($email);

    /**
     * Users will always login via an account URL. As a result, authentication must be done by
     * checking not only their email address exists, but also that they are assigned to the
     * specified account as a user of that account.
     *
     * @param string $email
     * @param integer $accountId
     * @return object|null
     */
    public function getByEmailAndAccount($email, $accountId);
}

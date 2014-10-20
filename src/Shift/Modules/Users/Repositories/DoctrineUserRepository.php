<?php

namespace Tectonic\Shift\Modules\Users\Repositories;

use Tectonic\Shift\Library\Support\Database\Doctrine\Repository;
use Tectonic\Shift\Modules\Accounts\Entities\Account;
use Tectonic\Shift\Modules\Users\Entities\User;

class DoctrineUserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * Required entity setting.
     *
     * @var string
     */
    protected $entity = User::class;

    /**
     * Users are technically not restricted by account. A user can have a user account with multiple
     * accounts on the system. You can check the relationships on the user entity for this information.
     *
     * @var bool
     */
    public $restrictByAccount = false;

    /**
     * Creates a new User instance based on the array of data provided.
     *
     * @param array $data
     * @return User
     */
    public function getNew(array $data = [])
    {
        return new User($data['firstName'], $data['lastName'], $data['email'], $data['password']);;
    }

    /**
     * Retrieve a user based on the email. This is also restricted by the current account. If
     * no user exists by that email address that is also associated with the account,
     *
     * @param string $email
     * @return User
     */
    public function getByEmail($email)
    {
        $query = $this->entityManager()->createQuery()
            ->select($this->entity.' users')
            ->where('users.email = :email')
            ->setParameter('email', $email);

        return $query->getSingleResult();
    }

    /**
     * Same as getByEmail, but also allows for restriction by account id.
     *
     * @param string $email
     * @param integer $accountId
     * @return User
     */
    public function getByEmailAndAccount($email, $accountId)
    {
        $query = $this->entityManager()->createQuery()
            ->select($this->entity.' users')
            ->join('users.accounts', Account::class)
            ->where('users.email = :email')
            ->where('users.accounts.id = :accountId')
            ->setParameter('email', $email)
            ->setParameter('accountId', $accountId);

        return $query->getSingleResult();
    }
}

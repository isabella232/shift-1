<?php
namespace Tectonic\Shift\Modules\Identity\Users\Repositories;

use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

class EloquentUserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * Users are not technically restricted by account.
     *
     * @var bool
     */
    public $restrictByAccount = false;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
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
        return $this->getBy('email', $email)->first();
    }

    /**
     * Same as getByEmail, but also allows for restriction by account id.
     *
     * @param string $email
     * @param AccountInterface $account
     * @return User
     */
    public function getByEmailAndAccount($email, $account)
    {
        $user = $this->getQuery()->whereHas('accounts', function($query) use ($account) {
            $query->where('accounts.id', '=', $account->getId());
        })->whereEmail($email)->first();

        return $user;
    }
}
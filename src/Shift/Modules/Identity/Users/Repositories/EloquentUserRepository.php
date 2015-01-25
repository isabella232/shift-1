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

    /**
     * Get a list of account ids with account name a user belongs to.
     *
     * @param      $user
     * @param null $queryString
     *
     * @return array
     */
    public function getAccounts($user, $queryString = null)
    {
        $queryResult = $this->getQuery()->where('id', '=', $user->id)->first();

        $results = [];

        foreach ($queryResult->accounts as $account)
        {
            $language = $account->language;

            $nameTranslation = $account->translations()
                ->where('field', '=', 'name')
                ->where('value', 'LIKE', "%{$queryString}%")
                ->first();

            $results[] = ['id' => $account->id, 'text' => $nameTranslation['value']];
        }

        return $results;
    }

    /**
     * Search for a list of users based on name.
     *
     * @param string $name
     * @param integer $limit
     * @return mixed
     */
    public function getAllByName($name, $limit = 8)
    {
        $query = $this->getQuery();
        $query = $query->where(function($query) use ($name) {
            $query->orWhere('first_name', 'LIKE', '%'.$name.'%');
            $query->orWhere('last_name', 'LIKE', '%'.$name.'%');
        });

        return $query->take($limit)->get();
    }
}

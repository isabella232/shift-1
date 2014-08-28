<?php

namespace Tectonic\Shift\Modules\Accounts\Repositories;

use Tectonic\Shift\Modules\Accounts\Models\User;
use Tectonic\Shift\Library\Support\SqlBaseRepository;

class SqlUserRepository extends SqlBaseRepository implements UserRepositoryInterface
{
	public function __construct(User $user)
	{
		$this->setModel($user);
	}

    /**
     * Returns a user object based on the email address provided.
     *
     * @param $email
     * @return mixed
     */
    public function getByEmail($email)
    {
        return $this->model->whereEmail($email)->get();
    }
}

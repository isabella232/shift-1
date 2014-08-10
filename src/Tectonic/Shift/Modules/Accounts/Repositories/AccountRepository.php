<?php

namespace Tectonic\Shift\Modules\Accounts\Repositories;

use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Library\Support\SqlBaseRepository;

class AccountRepository extends SqlBaseRepository implements AccountRepositoryInterface
{
	public function __construct(Account $account)
	{
		$this->setModel($account);
	}

	/**
	 * If a domain is not found, generally speaking it's a bad error - either something
	 * has been mis-configured or a user has accidentally accessed the wrong site.
	 *
	 * @param $domain
	 * @return Account
	 * @throws ModelNotFoundException
	 */
	public function requireByDomain($domain)
	{
		$account = $this->model->whereDomain($domain)->first();

		if (!$account) {
			throw with(new ModelNotFoundException)->setModel(get_class($this->model));
		}

		return $account;
	}
}

<?php

namespace Tectonic\Shift\Modules\Accounts\Repositories;

use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentAccountRepository extends Repository implements AccountRepositoryInterface
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
	 * @throws Illuminate\Database\Eloquent\ModelNotFoundException
	 */
	public function requireByDomain($domain)
	{
		$domainQuery = function($query) use ($domain) {
			$query->whereDomain($domain);
		};

		$account = $this->model->whereHas('domains', $domainQuery)->first();

		if (!$account) {
			throw with(new ModelNotFoundException)->setModel(get_class($this->model));
		}

		return $account;
	}
}

<?php

namespace Tectonic\Shift\Modules\Accounts\Services;

use Tectonic\Shift\Modules\Accounts\Models\Account;

class AccountsService
{
	/**
	 * Stores the current account that a given request is for.
	 *
	 * @var Account
	 */
	private $account;

	/**
	 * @param Account $account
	 */
	public function setCurrentAccount(Account $account)
	{
		$this->account = $account;
	}

	/**
	 * Returns the current account that the request is dealing with.
	 *
	 * @return Account
	 */
	public function getCurrentAccount()
	{
		return $this->account;
	}
}

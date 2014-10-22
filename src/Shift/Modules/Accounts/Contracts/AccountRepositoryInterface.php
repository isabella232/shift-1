<?php
namespace Tectonic\Shift\Modules\Accounts\Contracts;

use Tectonic\Shift\Library\Support\Database\RepositoryInterface;
use Tectonic\Shift\Modules\Users\Contracts\UserInterface;

interface AccountRepositoryInterface extends RepositoryInterface
{
	/**
	 * Searches for a domain, should throw an exception if it fails.
	 *
	 * @param $domains
	 * @return mixed
	 */
	public function requireByDomain($domains);

	/**
	 * Searches for a domain, but simply returns the result.
	 *
	 * @param $domains
	 * @return mixed
	 */
	public function getByDomain($domains);

    /**
     * Return the total number of accounts currently available on the system.
     *
     * @return mixed
     */
    public function getCount();

    /**
     * Add a new user to the account.
     *
     * @param AccountInterface $account
     * @param UserInterface $user
     * @return mixed
     */
    public function addUser(AccountInterface $account, UserInterface $user);
}

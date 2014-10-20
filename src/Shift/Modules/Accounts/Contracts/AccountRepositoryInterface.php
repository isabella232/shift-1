<?php

namespace Tectonic\Shift\Modules\Accounts\Contracts;

use Tectonic\Shift\Library\Support\Database\RepositoryInterface;

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
}

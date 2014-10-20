<?php

namespace Tectonic\Shift\Library\Authorization;

interface UserInterface
{
	/**
	 * Returns the id of the user.
	 *
	 * @return mixed
	 */
	public function getId();

    /**
     * Returns an array of accounts.
     *
     * @return array
     */
    public function getAccounts();
}

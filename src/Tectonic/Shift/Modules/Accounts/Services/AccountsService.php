<?php

namespace Tectonic\Shift\Modules\Accounts\Services;
use Tectonic\Shift\Library\Authorization\AuthenticatedConsumer;

/**
 * Class AccountsService
 *
 * The accounts service provides some methods for working with accounts and eases the use of working with
 * 1 or more accounts when logged in as an authenticated consumer that has access to those accounts.
 *
 * @package Tectonic\Shift\Modules\Accounts\Services
 */

class AccountsService
{
    /**
     * @var \Tectonic\Shift\Library\Authorization\AuthenticatedConsumer
     */
    private $authenticatedConsumer;

    /**
     * @param AuthenticatedConsumer $authenticatedConsumer
     */
    public function __construct(AuthenticatedConsumer $authenticatedConsumer)
    {
        $this->authenticatedConsumer = $authenticatedConsumer;
    }
    
    /**
     * Returns the account id for the currently authenticated user or 3rd party API token, and the
     * account that they are CURRENTLY working with. An authenticated consumer can have access to
     * numerous accounts, but will only work with one account at any given time.
     *
     * @return integer
     */
    public function getCurrentAccountId()
    {
        return $this->authenticatedConsumer->getAccountId();
    }

    /**
     * Returns the accounts that an authenticated consumer has access to.
     *
     * @return array Account
     */
    public function getAccounts()
    {
        return $this->authenticatedConsumer->getAccounts();
    }
}

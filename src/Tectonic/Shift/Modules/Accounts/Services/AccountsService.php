<?php

namespace Tectonic\Shift\Modules\Accounts\Services;

use Illuminate\Auth\Guard;

/**
 * Class AccountsService
 *
 * The accounts service provides some methods for working with accounts.
 *
 * @package Tectonic\Shift\Modules\Accounts\Services
 */
class AccountsService
{
    /**
     * @var \Illuminate\Auth\Guard
     */
    protected $auth;

    /**
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Returns the account id for the currently authenticated user or 3rd party API token.
     *
     * @todo Implement logic for 3rd party api token.
     *
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->auth->user()->account_id;
    }
}

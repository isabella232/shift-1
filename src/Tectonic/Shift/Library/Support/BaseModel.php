<?php

namespace Tectonic\Shift\Library\Support;

use Tectonic\Shift\Modules\Accounts\Services\AccountsService;

class BaseModel extends \Eloquent
{
    /**
     * If the data relating to this model is restricted by account, then we can alter
     * all models by restricting the query by the account id.
     *
     * @var boolean
     */
    protected $accountRestricted = false;

    /**
     * Account restriction can be enabled or disabled based on requirements. For example, users
     * who are part of a role that can manage accounts, generally do not need to be restricted
     * by account. This property exists for 99%+ of our user base.
     *
     * @var bool
     */
    protected static $accountRestrictionEnabled = true;

    /**
     * If a missing method is called, we create a new query based on the account id
     * restriction.
     *
     * @param string $method
     * @param array $arguments
     */
    public function __call($method, $arguments)
    {
        if ($this->accountRestricted && static::$accountRestrictionEnabled) {
            return $this->whereAccountId(/* @TODO: get the account id */);
        }

        return parent::__call($method, $arguments);
    }

    /**
     * Enables account restriction for future queries.
     */
    public static function enableAccountRestriction()
    {
        static::$accountRestrictionEnabled = true;
    }

    /**
     * Disables account restriction for future queries.
     */
    public static function disableAccountRestriction()
    {
        static::$accountRestrictionEnabled = false;
    }
}

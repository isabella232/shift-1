<?php

namespace Tectonic\Shift\Library\Support\Database\Eloquent;

class Model extends \Eloquent
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
        // We have to disable account restriction when this passes, so that we do not end up
        // in an endless loop while tryint to access method that do not actually exist on model
        // objects (Eloquent passes them to the query builder). We then re-enable it for future
        // magic method calls. //- Kirk
        if ($this->accountRestricted && static::$accountRestrictionEnabled) {
            static::disableAccountRestriction();

            $query = $this->whereAccountId(/* @TODO: get the account id from the authenticated consumer */);

            call_user_func_array([$query, $method], $arguments);

            static::enableAccountRestriction();

            return $query;
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

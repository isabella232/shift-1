<?php

namespace Tectonic\Shift\Modules\Accounts\Hooks;

use Tectonic\Shift\Library\Search\SearchInterface;
use Tectonic\Shift\Modules\Accounts\Search\Filters\AccountFilter;

/**
 * Class QueryRestrictor
 *
 * The query constrictor gets applied to all relevant queries where necessary. It provides a base hook that can be
 * registered for any search query, which then registers the account search filter for that query.
 *
 * @package Tectonic\Shift\Modules\Accounts\Hooks
 */

class QueryRestrictor
{
    /**
     * The query restrictor must have the AccountFilter, inject it here.
     *
     * @param AccountFilter $accountFilter
     */
    public function __construct(AccountFilter $accountFilter)
    {
        $this->accountFilter = $accountFilter;
    }

    /**
     * Sets up the new account filter for the query, with the optional account id also being provided.
     *
     * @param string $accountIdField
     * @return callable
     */
    public function accountFilter($accountIdField = 'account_id')
    {
        $self = $this;

        return function(SearchInterface $search) use ($accountIdField, $self) {
            $self->accountFilter->setSearch($search);
            $self->accountFilter->setAccountIdField($accountIdField);

            $search->addFilter($self->accountFilter);
        };
    }
}

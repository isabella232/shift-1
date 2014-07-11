<?php

namespace Tectonic\Shift\Modules\Accounts\Search\Filters;

use Tectonic\Shift\Library\Search\Filters\SearchFilterInterface;

class AccountFilter extends SearchFilter implements SearchFilterInterface
{
    /**
     * The account id field for simple search queries, should just be account_id. However,
     * in some cases (with complex searches), the account_id may be ambiguous, so we allow
     * developers to define the field name if necessary.
     *
     * @var string
     */
    protected $accountIdField = 'account_id';

    /**
     * Stores the accounts service object.
     *
     * @var
     */
    protected $accountService;

    /**
     * Simple constructor, some basic dependency injection.
     *
     * @param AccountsService $accountsService
     */
    public function __construct(AccountsService $accountsService)
    {
        $this->accountsService = $accountsService;
    }

	/**
	 * Restricts a query based on the account id
	 */
	public function criteria()
	{
        $accountId = $this->accountsService->getAccountId();

        $this->getQuery()->where($this->accountIdField, '=', $accountId);
	}

    /**
     * Set the account id field name.
     *
     * @param $fieldName
     */
    public function setAccountIdField($fieldName)
    {
        $this->accountIdField = $fieldName;
    }
}
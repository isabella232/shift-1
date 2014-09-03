<?php

namespace Tectonic\Shift\Modules\Accounts\Services;

use Tectonic\Shift\Library\Authorization\AuthenticatedConsumer;
use Tectonic\Shift\Modules\Accounts\Entities\Account;
use Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Repositories\DomainRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Validators\DomainValidation;

class AccountDomainsService
{
    /**
     * @var \Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface
     */
    private $accountRepository;

    /**
     * @var \Tectonic\Shift\Modules\Accounts\Repositories\DomainRepositoryInterface
     */
    private $domainRepository;

    public function __construct(AccountRepositoryInterface $accountRepository, DomainRepositoryInterface $domainRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->domainRepository = $domainRepository;
    }

    /**
     * Adds a new domain to an account.
     *
     * @param $input
     * @param Account $account
     * @return mixed
     */
    public function addDomain($input, Account $account)
    {
        (new DomainValidation)->setInput($input)->validate();

        $domain = $this->domainRepository->getNew($input);
        $domain->account = $account;

        return $this->domainRepository->save($domain);
    }

    public function addDomainForCurrentAccount()
    {

    }
}

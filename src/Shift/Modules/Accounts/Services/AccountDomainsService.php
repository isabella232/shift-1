<?php

namespace Tectonic\Shift\Modules\Accounts\Services;

use Tectonic\Shift\Library\Authorization\Consumer;
use Tectonic\Shift\Modules\Accounts\Entities\Account;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Repositories\DomainRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Validators\DomainValidation;

class AccountDomainsService
{
    /**
     * @var \Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface
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
     * @param Account $account
     * @param string $domain
     * @return mixed
     */
    public function addDomain(Account $account, $domain)
    {
        $domainData = [
            'account' => $account,
            'domain' => $domain
        ];

        (new DomainValidation)->setInput($domainData)->validate();

        $domain = $this->domainRepository->getNew($domainData);

        return $this->domainRepository->save($domain);
    }
}

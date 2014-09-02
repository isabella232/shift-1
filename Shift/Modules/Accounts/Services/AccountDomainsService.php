<?php

namespace Tectonic\Shift\Modules\Accounts\Services;

use Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface;

class AccountDomainsService
{
    /**
     * @var \Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface
     */
    private $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function addDomain($input)
    {

    }
}

<?php

namespace Tectonic\Shift\Modules\Installation\Services;

use Tectonic\Shift\Library\Validation\ValidationException;
use Tectonic\Shift\Modules\Accounts\Services\AccountDomainsService;
use Tectonic\Shift\Modules\Accounts\Services\AccountManagementService;
use Tectonic\Shift\Modules\Installation\Contracts\InstallationListenerInterface;
use Tectonic\Shift\Modules\Installation\Validators\InstallValidation;

class InstallService
{
    /**
     * @var AccountManagementService
     */
    private $accountsService;

    /**
     * @var AccountDomainsService
     */
    private $accountDomainsService;

    /**
     * @param AccountManagementService $accountsService
     */
    public function __construct(AccountManagementService $accountsService, AccountDomainsService $accountDomainsService)
    {
        $this->accountsService = $accountsService;
        $this->accountDomainsService = $accountDomainsService;
    }

    /**
     * Called on a new installation of Shift. Validates the input provided
     *
     * @param array $input
     * @param InstallationListenerInterface $listener
     * @return mixed
     */
    public function freshInstall(array $input = [], InstallationListenerInterface $listener)
    {
        try {
            $validation = new InstallValidation;
            $validation->setInput($input);
            $validation->validate();

            $accountData = ['name' => $input['name']];
            $domainData = ['domain' => $input['host']];

            $account = $this->accountsService->create($accountData);

            $this->accountDomainsService->addDomain($account, $input['host']);
        }
        catch (ValidationException $exception) {
            return $listener->onValidationFailure($exception);
        }

        return $listener->onSuccess();
    }
}

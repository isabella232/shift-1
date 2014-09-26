<?php

namespace Tectonic\Shift\Modules\Installation\Services;

use Event;
use Tectonic\Shift\Library\Validation\ValidationException;
use Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Services\AccountDomainsService;
use Tectonic\Shift\Modules\Accounts\Services\AccountManagementService;
use Tectonic\Shift\Modules\Accounts\Services\AccountOwnershipService;
use Tectonic\Shift\Modules\Installation\Contracts\InstallationListenerInterface;
use Tectonic\Shift\Modules\Installation\Validators\InstallValidation;
use Tectonic\Shift\Modules\Users\Services\UserManagementService;

class InstallService
{
    /**
     * @var AccountDomainsService
     */
    private $accountDomainsService;

    /**
     * @var AccountOwnershipService
     */
    private $ownershipService;

    /**
     * @var UserManagementService
     */
    private $userManagementService;

    /**
     * @var AccountRepositoryInterface
     */
    private $accountsRepository;

    /**
     * @param AccountRepositoryInterface $accountsRepository
     * @param AccountDomainsService $accountDomainsService
     * @param AccountOwnershipService $ownershipService
     * @param UserManagementService $userManagementService
     */
    public function __construct(
        AccountRepositoryInterface $accountsRepository,
        AccountDomainsService $accountDomainsService,
        AccountOwnershipService $ownershipService,
        UserManagementService $userManagementService
    )
    {
        $this->accountDomainsService = $accountDomainsService;
        $this->ownershipService = $ownershipService;
        $this->userManagementService = $userManagementService;
        $this->accountsRepository = $accountsRepository;
    }

    /**
     * Called on a new installation of Shift. Validates the input provided
     *
     * @fires Shift: installed
     * @param array $input
     * @param InstallationListenerInterface $listener
     * @return mixed
     */
    public function freshInstall(array $input = [], InstallationListenerInterface $listener)
    {
        try {
            $this->validate($input);
            $account = $this->setupAccount($input);
        }
        catch (ValidationException $exception) {
            return $listener->onValidationFailure($exception);
        }

        Event::fire('Shift: installed', [$account]);

        return $listener->onSuccess();
    }

    /**
     * Validate the input that was provided from the setup process.
     *
     * @param array $input
     * @return InstallValidation
     * @throws ValidationException
     */
    public function validate(array $input = [])
    {
        $validation = new InstallValidation;
        $validation->setInput($input);
        $validation->validate();

        return $validation;
    }

    /**
     * Setup a new account, with a domain and user as well.
     *
     * @param $input
     * @return mixed
     */
    public function setupAccount($input)
    {
        $accountData = array_only($input, ['name']);
        $userData = array_merge(array_only($input, ['email', 'password']), ['firstName' => 'Super', 'lastName' => 'Admin']);

        $user = $this->userManagementService->create($userData);

        $account = $this->accountsRepository->getNew($accountData);
        $account->setOwner($user);
        $account->addUser($user);
        $this->accountsRepository->save($account);

        $this->accountDomainsService->addDomain($account, $input['host']);

        return $account;
    }
}

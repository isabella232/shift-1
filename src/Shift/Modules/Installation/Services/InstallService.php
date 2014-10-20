<?php

namespace Tectonic\Shift\Modules\Installation\Services;

use Event;
use Tectonic\Shift\Library\Validation\ValidationException;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Services\AccountDomainsService;
use Tectonic\Shift\Modules\Accounts\Services\AccountOwnershipService;
use Tectonic\Shift\Modules\Installation\Contracts\InstallationListenerInterface;
use Tectonic\Shift\Modules\Installation\Validators\InstallValidation;
use Tectonic\Shift\Modules\Localisation\Services\LocaleManagementService;
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
     * @var LocaleManagementService
     */
    private $localeManagementService;

    /**
     * @param AccountRepositoryInterface $accountsRepository
     * @param AccountDomainsService $accountDomainsService
     * @param AccountOwnershipService $ownershipService
     * @param UserManagementService $userManagementService
     * @param LocaleManagementService $localeManagementService
     */
    public function __construct(
        AccountRepositoryInterface $accountsRepository,
        AccountDomainsService $accountDomainsService,
        AccountOwnershipService $ownershipService,
        UserManagementService $userManagementService,
        LocaleManagementService $localeManagementService
    )
    {
        $this->accountDomainsService = $accountDomainsService;
        $this->ownershipService = $ownershipService;
        $this->userManagementService = $userManagementService;
        $this->accountsRepository = $accountsRepository;
        $this->localeManagementService = $localeManagementService;
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
            $this->validate($input);
            $this->installShift($input);
        }
        catch (ValidationException $exception) {
            return $listener->onValidationFailure($exception);
        }

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
     * Installs shift, setting up any required data that is general to shift operations. At
     * this particular point in time, the Install service doesn't actually do anything itself
     * other than validate the input and fire a few events. Other modules then hook into those
     * events to setup their required data.
     *
     * @fires shift.installed
     * @fires shift.installing
     * @param array $input
     */
    public function installShift(array $input = [])
    {
        Event::fire('shift.installing', [$input]);
        Event::fire('shift.installed', [$input]);
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
        $locale = $this->setupLocale();
        $user = $this->setupUser($input);

        $account = $this->accountsRepository->getNew($accountData);

        $account->setOwner($user);
        $account->addUser($user);
        $account->addLocale($locale);

        $this->accountsRepository->save($account);

        $this->accountDomainsService->addDomain($account, $input['host']);

        return $account;
    }

    /**
     * Setup default locale
     *
     * @return mixed
     * */
    public function setupLocale()
    {
        $data = ['locale' => 'English (Great Britain)', 'code' => 'en_GB'];
        $locale = $this->localeManagementService->create($data);

        return $locale;
    }

    /**
     * Creates a new user for the account based on the input provided.
     *
     * @param array $input
     * @return mixed
     */
    public function setupUser(array $input)
    {
        $userData = array_merge(array_only($input, ['email', 'password', 'passwordConfirmation']), ['firstName' => 'Super', 'lastName' => 'Admin']);

        return $this->userManagementService->create($userData);
    }
}
